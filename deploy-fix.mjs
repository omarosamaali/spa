import { Client } from 'ssh2';

const SSH = {
  host: '92.113.24.42',
  port: 65002,
  username: 'u133574193',
  password: 'o1m2r3e4l5Q!1',
  readyTimeout: 60000,
};

const DOMAIN = 'slategrey-panther-404589.hostingersite.com';
const APP_DIR = `/home/u133574193/domains/${DOMAIN}/nayspa`;
const PUBLIC_HTML = `/home/u133574193/domains/${DOMAIN}/public_html`;

// ⬇️ UPDATE THIS WITH THE ACTUAL DB PASSWORD FROM HOSTINGER
const DB_PASS = process.argv[2] || 'NaySpa@2024!';

function runCmd(conn, cmd, showOutput = true) {
  return new Promise((resolve, reject) => {
    conn.exec(cmd, (err, stream) => {
      if (err) return reject(err);
      let out = '';
      stream.on('data', d => { out += d.toString(); if (showOutput) process.stdout.write(d.toString()); });
      stream.stderr.on('data', d => { out += d.toString(); if (showOutput) process.stderr.write(d.toString()); });
      stream.on('close', () => resolve(out.trim()));
    });
  });
}

async function step(title, fn) {
  console.log(`\n${'='.repeat(55)}\n🔧  ${title}\n${'='.repeat(55)}`);
  return await fn();
}

async function main() {
  const conn = new Client();
  await new Promise((res, rej) => conn.on('ready', res).on('error', rej).connect(SSH));
  console.log('✅ SSH Connected!');
  console.log(`🔑  Testing DB password: ${DB_PASS}\n`);

  // === 1. Test DB connection ===
  await step('Testing DB connection', async () => {
    const result = await runCmd(conn,
      `mysql -u u133574193_nay_spa -p'${DB_PASS}' -h localhost -e "SELECT 'DB_OK' as status;" 2>&1`
    );
    if (result.includes('DB_OK')) {
      console.log('✅ DB connection successful!');
    } else {
      console.log('❌ DB connection failed! Check password.');
    }
  });

  // === 2. Update .env with correct password ===
  await step('Updating .env', async () => {
    await runCmd(conn, `sed -i "s|DB_PASSWORD=.*|DB_PASSWORD=${DB_PASS}|" ${APP_DIR}/.env`);
    await runCmd(conn, `sed -i "s|DB_HOST=.*|DB_HOST=localhost|" ${APP_DIR}/.env`);
    await runCmd(conn, `grep DB_ ${APP_DIR}/.env`);
  });

  // === 3. Fix git conflict and pull latest ===
  await step('Fixing git and pulling latest code', async () => {
    await runCmd(conn, `cd ${APP_DIR} && git checkout -- .gitignore 2>&1`);
    await runCmd(conn, `cd ${APP_DIR} && git pull origin main 2>&1`);
  });

  // === 4. Run migrations ===
  await step('Running migrations + seed', async () => {
    await runCmd(conn, `cd ${APP_DIR} && php artisan config:clear 2>&1`);
    await runCmd(conn, `cd ${APP_DIR} && php artisan migrate:fresh --seed --force 2>&1`);
  });

  // === 5. Re-cache ===
  await step('Caching config/routes/views', async () => {
    await runCmd(conn, `cd ${APP_DIR} && php artisan config:cache 2>&1`);
    await runCmd(conn, `cd ${APP_DIR} && php artisan route:cache 2>&1`);
    await runCmd(conn, `cd ${APP_DIR} && php artisan view:cache 2>&1`);
  });

  // === 6. Final test ===
  await step('Testing site', async () => {
    const r = await runCmd(conn, `curl -s -o /dev/null -w "%{http_code}" https://${DOMAIN}/`);
    const code = r.trim();
    if (code === '200') {
      console.log(`✅ Site is UP! HTTP ${code}`);
    } else {
      console.log(`⚠️  HTTP ${code}`);
      // Show Laravel error log
      await runCmd(conn, `tail -30 ${APP_DIR}/storage/logs/laravel.log 2>/dev/null || echo "No log file"`);
    }
  });

  console.log('\n' + '='.repeat(55));
  console.log('🎉  DONE!');
  console.log(`🌐  https://${DOMAIN}`);
  console.log(`🔐  https://${DOMAIN}/admin/login`);
  console.log('='.repeat(55) + '\n');

  conn.end();
}

main().catch(e => console.error('❌ Error:', e.message));
