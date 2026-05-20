import { Client } from 'ssh2';

const SSH = {
  host: '92.113.24.42',
  port: 65002,
  username: 'u133574193',
  password: 'o1m2r3e4l5Q!1',
  readyTimeout: 60000,
};

const NEW_DOMAIN   = 'smartbookiq.com';
const OLD_DOMAIN   = 'slategrey-panther-404589.hostingersite.com';
const HOME         = '/home/u133574193';
const NEW_APP_DIR  = `${HOME}/domains/${NEW_DOMAIN}/nayspa`;
const NEW_PUB_HTML = `${HOME}/domains/${NEW_DOMAIN}/public_html`;
const OLD_APP_DIR  = `${HOME}/domains/${OLD_DOMAIN}/nayspa`;

const DB = {
  name: 'u133574193_spa',
  user: 'u133574193_spa',
  pass: 'o1m2r3e4l5Q!1',
  host: 'localhost',
};

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
  console.log(`\n${'='.repeat(60)}\n🔧  ${title}\n${'='.repeat(60)}`);
  return await fn();
}

async function main() {
  const conn = new Client();
  await new Promise((res, rej) => conn.on('ready', res).on('error', rej).connect(SSH));
  console.log('✅ SSH Connected!\n');

  // === 1. Check new domain folder ===
  await step('Checking new domain structure', async () => {
    await runCmd(conn, `ls ${HOME}/domains/`);
    await runCmd(conn, `ls ${NEW_PUB_HTML}/ 2>/dev/null || echo "public_html empty"`);
  });

  // === 2. Test DB connection ===
  await step('Testing DB connection', async () => {
    const r = await runCmd(conn,
      `mysql -u ${DB.user} -p'${DB.pass}' -h ${DB.host} -e "SELECT 'DB_OK';" 2>&1`
    );
    if (r.includes('DB_OK')) {
      console.log('✅ DB Connected successfully!');
    } else {
      console.log('❌ DB connection failed!');
    }
  });

  // === 3. Clone or copy project to new domain ===
  await step('Setting up project in new domain', async () => {
    // Remove old if exists
    await runCmd(conn, `rm -rf ${NEW_APP_DIR}`);

    // Clone fresh from GitHub
    const cloneResult = await runCmd(conn,
      `git clone https://github.com/omarosamaali/spa.git ${NEW_APP_DIR} 2>&1`
    );
    console.log(cloneResult);
  });

  // === 4. Create .env ===
  await step('Creating .env', async () => {
    const env = [
      `APP_NAME="NAY SPA"`,
      `APP_ENV=production`,
      `APP_KEY=`,
      `APP_DEBUG=false`,
      `APP_URL=https://${NEW_DOMAIN}`,
      ``,
      `APP_LOCALE=ar`,
      `APP_FALLBACK_LOCALE=ar`,
      ``,
      `LOG_CHANNEL=stack`,
      `LOG_STACK=single`,
      `LOG_LEVEL=error`,
      ``,
      `DB_CONNECTION=mysql`,
      `DB_HOST=${DB.host}`,
      `DB_PORT=3306`,
      `DB_DATABASE=${DB.name}`,
      `DB_USERNAME=${DB.user}`,
      `DB_PASSWORD=${DB.pass}`,
      ``,
      `SESSION_DRIVER=database`,
      `SESSION_LIFETIME=120`,
      `FILESYSTEM_DISK=local`,
      `QUEUE_CONNECTION=database`,
      `CACHE_STORE=database`,
      ``,
      `MAIL_MAILER=log`,
      `MAIL_FROM_ADDRESS="info@${NEW_DOMAIN}"`,
      `MAIL_FROM_NAME="NAY SPA"`,
    ].join('\n');

    // Write line by line to avoid shell escaping issues
    await runCmd(conn, `printf '%s\n' ${JSON.stringify(env)} > ${NEW_APP_DIR}/.env`);
    await runCmd(conn, `cat ${NEW_APP_DIR}/.env`);
  });

  // === 5. Composer install ===
  await step('Installing PHP dependencies', async () => {
    await runCmd(conn,
      `cd ${NEW_APP_DIR} && composer install --optimize-autoloader --no-dev --no-interaction 2>&1`
    );
  });

  // === 6. App key ===
  await step('Generating app key', async () => {
    await runCmd(conn, `cd ${NEW_APP_DIR} && php artisan key:generate --force 2>&1`);
  });

  // === 7. Migrate + seed ===
  await step('Running migrations + seed', async () => {
    await runCmd(conn, `cd ${NEW_APP_DIR} && php artisan config:clear 2>&1`);
    await runCmd(conn, `cd ${NEW_APP_DIR} && php artisan migrate:fresh --seed --force 2>&1`);
  });

  // === 8. Setup public_html ===
  await step('Configuring public_html', async () => {
    // Backup default
    await runCmd(conn, `mv ${NEW_PUB_HTML}/index.php ${NEW_PUB_HTML}/index.php.bak 2>/dev/null; true`);

    // Write custom index.php pointing to our Laravel app
    const indexPhp = `<?php
define('LARAVEL_START', microtime(true));
if (file_exists($maintenance = __DIR__.'/../nayspa/storage/framework/maintenance.php')) {
    require $maintenance;
}
require __DIR__.'/../nayspa/vendor/autoload.php';
$app = require_once __DIR__.'/../nayspa/bootstrap/app.php';
$app->bind('path.public', function() { return __DIR__; });
$kernel = $app->make(Illuminate\\Contracts\\Http\\Kernel::class);
$response = $kernel->handle($request = Illuminate\\Http\\Request::capture())->send();
$kernel->terminate($request, $response);`;

    await runCmd(conn, `printf '%s\n' ${JSON.stringify(indexPhp)} > ${NEW_PUB_HTML}/index.php`);

    // Copy .htaccess from Laravel public
    await runCmd(conn, `cp ${NEW_APP_DIR}/public/.htaccess ${NEW_PUB_HTML}/.htaccess`);

    // Copy build assets
    await runCmd(conn, `cp -r ${NEW_APP_DIR}/public/build ${NEW_PUB_HTML}/build 2>/dev/null; true`);
    await runCmd(conn, `cp -r ${NEW_APP_DIR}/public/favicon.ico ${NEW_PUB_HTML}/ 2>/dev/null; true`);

    // Storage symlink manually
    await runCmd(conn, `rm -rf ${NEW_PUB_HTML}/storage`);
    await runCmd(conn, `ln -sfn ${NEW_APP_DIR}/storage/app/public ${NEW_PUB_HTML}/storage`);

    await runCmd(conn, `ls -la ${NEW_PUB_HTML}/`);
  });

  // === 9. Permissions ===
  await step('Setting permissions', async () => {
    await runCmd(conn, `chmod -R 755 ${NEW_APP_DIR}`);
    await runCmd(conn, `chmod -R 775 ${NEW_APP_DIR}/storage ${NEW_APP_DIR}/bootstrap/cache`);
  });

  // === 10. Cache ===
  await step('Caching config/routes/views', async () => {
    await runCmd(conn, `cd ${NEW_APP_DIR} && php artisan config:cache 2>&1`);
    await runCmd(conn, `cd ${NEW_APP_DIR} && php artisan route:cache 2>&1`);
    await runCmd(conn, `cd ${NEW_APP_DIR} && php artisan view:cache 2>&1`);
  });

  // === 11. Test ===
  await step('Testing site', async () => {
    const r = await runCmd(conn, `curl -sk -o /dev/null -w "%{http_code}" https://${NEW_DOMAIN}/`);
    console.log(`\nHTTP Status: ${r}`);
    if (r === '200') {
      console.log('✅ Site is LIVE!');
    } else {
      // Show error log
      await runCmd(conn, `tail -20 ${NEW_APP_DIR}/storage/logs/laravel.log 2>/dev/null || echo "No log"`);
    }
  });

  console.log(`
${'='.repeat(60)}
🎉  DEPLOYMENT COMPLETE!
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
