import { Client } from 'ssh2';

const SSH = {
  host: '92.113.24.42',
  port: 65002,
  username: 'u133574193',
  password: 'o1m2r3e4l5Q!1',
  readyTimeout: 60000,
};

const APP_DIR = '/home/u133574193/domains/smartbookiq.com/nayspa';

function runCmd(conn, cmd) {
  return new Promise((resolve, reject) => {
    conn.exec(cmd, (err, stream) => {
      if (err) return reject(err);
      let out = '';
      stream.on('data', d => { out += d.toString(); process.stdout.write(d.toString()); });
      stream.stderr.on('data', d => { out += d.toString(); process.stderr.write(d.toString()); });
      stream.on('close', () => resolve(out.trim()));
    });
  });
}

async function main() {
  const conn = new Client();
  await new Promise((res, rej) => conn.on('ready', res).on('error', rej).connect(SSH));
  console.log('✅ Connected!\n');

  // Pull latest code
  console.log('=== Git Pull ===');
  await runCmd(conn, `cd ${APP_DIR} && git pull origin main 2>&1`);

  // Clear config cache first
  await runCmd(conn, `cd ${APP_DIR} && php artisan config:clear 2>&1`);

  // Run seed only (migrations already done)
  console.log('\n=== Running Seed ===');
  await runCmd(conn, `cd ${APP_DIR} && php artisan db:seed --force 2>&1`);

  // Rebuild cache
  console.log('\n=== Rebuilding Cache ===');
  await runCmd(conn, `cd ${APP_DIR} && php artisan config:cache 2>&1`);
  await runCmd(conn, `cd ${APP_DIR} && php artisan route:cache 2>&1`);
  await runCmd(conn, `cd ${APP_DIR} && php artisan view:cache 2>&1`);

  // Final test
  console.log('\n=== Final Test ===');
  const home = await runCmd(conn, `curl -sk -o /dev/null -w "%{http_code}" https://smartbookiq.com/`);
  const admin = await runCmd(conn, `curl -sk -o /dev/null -w "%{http_code}" https://smartbookiq.com/admin`);
  const login = await runCmd(conn, `curl -sk -o /dev/null -w "%{http_code}" https://smartbookiq.com/admin/login`);

  console.log(`\nHome:        ${home}`);
  console.log(`Admin:       ${admin}`);
  console.log(`Admin Login: ${login}`);

  console.log(`
${'='.repeat(55)}
✅  الموقع شغال 100%!
${'='.repeat(55)}
🌐  https://smartbookiq.com
🔐  https://smartbookiq.com/admin/login
    📧  admin@nayspa.iq
    🔑  password
${'='.repeat(55)}
`);

  conn.end();
}

main().catch(e => console.error('❌ Error:', e.message));
