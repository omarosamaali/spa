import { Client } from 'ssh2';

const SSH = {
  host: '92.113.24.42',
  port: 65002,
  username: 'u133574193',
  password: 'o1m2r3e4l5Q!1',
  readyTimeout: 60000,
};

const APP = '/home/u133574193/domains/smartbookiq.com/nayspa';
const PUB = '/home/u133574193/domains/smartbookiq.com/public_html';

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

  console.log('--- Discarding local changes ---');
  await run(conn, `cd ${APP} && git checkout -- database/factories/UserFactory.php 2>/dev/null; true`);

  console.log('\n--- Git Pull ---');
  await run(conn, `cd ${APP} && git pull origin main 2>&1`);

  console.log('\n--- Sync build assets (rm + fresh copy) ---');
  await run(conn, `rm -rf ${PUB}/build && cp -r ${APP}/public/build ${PUB}/build && echo "Build synced OK"`);

  console.log('\n--- Migrate ---');
  await run(conn, `cd ${APP} && php artisan migrate --force 2>&1`);

  console.log('\n--- Seed site settings (if needed) ---');
  await run(conn, `cd ${APP} && php artisan db:seed --class=SiteSettingsSeeder --force 2>&1`);
  await run(conn, `cd ${APP} && php artisan db:seed --class=HeroSlidesSeeder --force 2>&1`);

  console.log('\n--- Clear & Cache ---');
  await run(conn, `cd ${APP} && php artisan optimize 2>&1`);

  console.log('\n--- Test ---');
  const s = await run(conn, `curl -sk -o /dev/null -w "%{http_code}" https://smartbookiq.com/`);
  console.log(`\nHome status: ${s.trim()}`);

  conn.end();
}

main().catch(e => console.error('Error:', e.message));
