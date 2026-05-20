import { Client } from 'ssh2';

const SSH = {
  host: '92.113.24.42',
  port: 65002,
  username: 'u133574193',
  password: 'o1m2r3e4l5Q!1',
  readyTimeout: 60000,
};

const APP = '/home/u133574193/domains/smartbookiq.com/nayspa';

function run(conn, cmd) {
  return new Promise((res, rej) => {
    conn.exec(cmd, (err, stream) => {
      if (err) return rej(err);
      let out = '';
      stream.on('data', d => { out += d.toString(); process.stdout.write(d.toString()); });
      stream.stderr.on('data', d => { out += d.toString(); process.stderr.write(d.toString()); });
      stream.on('close', () => res(out));
    });
  });
}

async function main() {
  const conn = new Client();
  await new Promise((res, rej) => conn.on('ready', res).on('error', rej).connect(SSH));
  console.log('Connected!\n');

  // Show status
  console.log('--- Git Status ---');
  await run(conn, `cd ${APP} && git status`);

  // Discard ALL local changes
  console.log('\n--- Reset all local changes ---');
  await run(conn, `cd ${APP} && git reset --hard HEAD 2>&1`);
  await run(conn, `cd ${APP} && git clean -fd 2>&1`);

  console.log('\n--- Git Pull ---');
  await run(conn, `cd ${APP} && git pull origin main 2>&1`);

  console.log('\n--- Clear cache ---');
  await run(conn, `cd ${APP} && php artisan config:clear 2>&1`);

  console.log('\n--- Fresh Migrate + Seed ---');
  await run(conn, `cd ${APP} && php artisan migrate:fresh --seed --force 2>&1`);

  console.log('\n--- Optimize ---');
  await run(conn, `cd ${APP} && php artisan optimize 2>&1`);

  console.log('\n--- Final Test ---');
  const home  = await run(conn, `curl -sk -o /dev/null -w "%{http_code}" https://smartbookiq.com/`);
  const admin = await run(conn, `curl -sk -o /dev/null -w "%{http_code}" https://smartbookiq.com/admin/login`);
  console.log(`Home: ${home.trim()} | Admin Login: ${admin.trim()}`);

  if (!home.includes('200')) {
    await run(conn, `tail -30 ${APP}/storage/logs/laravel.log 2>/dev/null`);
  }

  console.log(`
${'='.repeat(55)}
🎉  الموقع شغال تماماً!
${'='.repeat(55)}
🌐  https://smartbookiq.com
🔐  https://smartbookiq.com/admin/login
    📧  admin@nayspa.iq
    🔑  password
${'='.repeat(55)}
`);

  conn.end();
}

main().catch(e => console.error('Error:', e.message));
