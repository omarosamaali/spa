import { Client } from 'ssh2';
import SftpClient from 'ssh2-sftp-client';

const SSH = {
  host: '92.113.24.42',
  port: 65002,
  username: 'u133574193',
  password: 'o1m2r3e4l5Q!1',
  readyTimeout: 60000,
};

const NEW_DOMAIN   = 'smartbookiq.com';
const HOME         = '/home/u133574193';
const APP_DIR      = `${HOME}/domains/${NEW_DOMAIN}/nayspa`;

const DB = {
  name: 'u133574193_spa',
  user: 'u133574193_spa',
  pass: 'o1m2r3e4l5Q!1',
  host: 'localhost',
};

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
  // 1. Upload .env via SFTP
  console.log('\n========== Uploading .env via SFTP ==========');
  const envContent = `APP_NAME="NAY SPA"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://${NEW_DOMAIN}

APP_LOCALE=ar
APP_FALLBACK_LOCALE=ar

LOG_CHANNEL=stack
LOG_STACK=single
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=${DB.host}
DB_PORT=3306
DB_DATABASE=${DB.name}
DB_USERNAME=${DB.user}
DB_PASSWORD=${DB.pass}

SESSION_DRIVER=database
SESSION_LIFETIME=120
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database
CACHE_STORE=database

MAIL_MAILER=log
MAIL_FROM_ADDRESS=info@${NEW_DOMAIN}
MAIL_FROM_NAME="NAY SPA"
`;

  const sftp = new SftpClient();
  await sftp.connect({ ...SSH });
  const buf = Buffer.from(envContent, 'utf8');
  await sftp.put(buf, `${APP_DIR}/.env`);
  console.log('✅ .env uploaded!');
  await sftp.end();

  // 2. SSH for remaining commands
  const conn = new Client();
  await new Promise((res, rej) => conn.on('ready', res).on('error', rej).connect(SSH));
  console.log('✅ SSH Connected!');

  // Verify .env
  console.log('\n========== Verifying .env ==========');
  await runCmd(conn, `cat ${APP_DIR}/.env`);

  // Generate app key
  console.log('\n========== Generating App Key ==========');
  await runCmd(conn, `cd ${APP_DIR} && php artisan key:generate --force 2>&1`);

  // Run migrations
  console.log('\n========== Running Migrations + Seed ==========');
  await runCmd(conn, `cd ${APP_DIR} && php artisan config:clear 2>&1`);
  await runCmd(conn, `cd ${APP_DIR} && php artisan migrate:fresh --seed --force 2>&1`);

  // Cache everything
  console.log('\n========== Caching ==========');
  await runCmd(conn, `cd ${APP_DIR} && php artisan config:cache 2>&1`);
  await runCmd(conn, `cd ${APP_DIR} && php artisan route:cache 2>&1`);
  await runCmd(conn, `cd ${APP_DIR} && php artisan view:cache 2>&1`);

  // Test
  console.log('\n========== Testing ==========');
  const status = await runCmd(conn, `curl -sk -o /dev/null -w "%{http_code}" https://${NEW_DOMAIN}/`);
  const adminStatus = await runCmd(conn, `curl -sk -o /dev/null -w "%{http_code}" https://${NEW_DOMAIN}/admin/login`);
  console.log(`\nHome: ${status} | Admin Login: ${adminStatus}`);

  if (status !== '200') {
    await runCmd(conn, `tail -30 ${APP_DIR}/storage/logs/laravel.log 2>/dev/null || echo "No log"`);
  }

  console.log(`
${'='.repeat(60)}
🎉  ALL DONE!
${'='.repeat(60)}
🌐  https://${NEW_DOMAIN}
🔐  https://${NEW_DOMAIN}/admin/login
    Email:    admin@nayspa.iq
    Password: password
${'='.repeat(60)}
`);

  conn.end();
}

main().catch(e => console.error('❌ Error:', e.message));
