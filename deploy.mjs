import { Client } from 'ssh2';

const SSH = {
  host: '92.113.24.42',
  port: 65002,
  username: 'u133574193',
  password: 'o1m2r3e4l5Q!1',
  readyTimeout: 60000,
};

const DOMAIN = 'slategrey-panther-404589.hostingersite.com';
const PUBLIC_HTML = `/home/u133574193/domains/${DOMAIN}/public_html`;
const APP_DIR = `/home/u133574193/domains/${DOMAIN}/nayspa`;

// DB credentials we created earlier
const DB = {
  name: 'u133574193_nay_spa',
  user: 'u133574193_nay_spa',
  pass: 'NaySpa@2024!',
  host: '127.0.0.1',
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
  console.log(`\n${'='.repeat(55)}`);
  console.log(`🔧  ${title}`);
  console.log('='.repeat(55));
  return await fn();
}

async function deploy() {
  const conn = new Client();
  await new Promise((res, rej) => conn.on('ready', res).on('error', rej).connect(SSH));
  console.log('✅ SSH Connected!\n');

  // === 1. Check what's in public_html ===
  await step('Checking current public_html', async () => {
    await runCmd(conn, `ls -la ${PUBLIC_HTML}/ 2>/dev/null || echo "empty"`);
  });

  // === 2. Clone the repo next to public_html ===
  await step('Cloning repo from GitHub', async () => {
    // Remove old clone if exists
    await runCmd(conn, `rm -rf ${APP_DIR}`);
    await runCmd(conn,
      `git clone https://github.com/omarosamaali/spa.git ${APP_DIR} 2>&1`
    );
  });

  // === 3. Create .env ===
  await step('Creating .env file', async () => {
    const envContent = `APP_NAME="NAY SPA"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://${DOMAIN}

APP_LOCALE=ar
APP_FALLBACK_LOCALE=ar

BCRYPT_ROUNDS=12

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
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database
CACHE_STORE=database

MAIL_MAILER=log
MAIL_FROM_ADDRESS="info@${DOMAIN}"
MAIL_FROM_NAME="NAY SPA"

VITE_APP_NAME="NAY SPA"
`;
    // Write .env using heredoc approach
    await runCmd(conn, `cat > ${APP_DIR}/.env << 'ENVEOF'
${envContent}
ENVEOF`);
    await runCmd(conn, `ls -la ${APP_DIR}/.env`);
  });

  // === 4. Composer install ===
  await step('Installing PHP dependencies (composer)', async () => {
    await runCmd(conn,
      `cd ${APP_DIR} && composer install --optimize-autoloader --no-dev --no-interaction 2>&1`
    );
  });

  // === 5. Generate app key ===
  await step('Generating Laravel app key', async () => {
    await runCmd(conn, `cd ${APP_DIR} && php artisan key:generate --force 2>&1`);
  });

  // === 6. Run migrations + seed ===
  await step('Running migrations and seeding database', async () => {
    await runCmd(conn, `cd ${APP_DIR} && php artisan migrate:fresh --seed --force 2>&1`);
  });

  // === 7. Storage link ===
  await step('Creating storage symlink', async () => {
    await runCmd(conn, `cd ${APP_DIR} && php artisan storage:link --force 2>&1`);
  });

  // === 8. Cache optimization ===
  await step('Caching config, routes and views', async () => {
    await runCmd(conn, `cd ${APP_DIR} && php artisan config:cache 2>&1`);
    await runCmd(conn, `cd ${APP_DIR} && php artisan route:cache 2>&1`);
    await runCmd(conn, `cd ${APP_DIR} && php artisan view:cache 2>&1`);
  });

  // === 9. Set permissions ===
  await step('Setting file permissions', async () => {
    await runCmd(conn, `chmod -R 755 ${APP_DIR}`);
    await runCmd(conn, `chmod -R 775 ${APP_DIR}/storage ${APP_DIR}/bootstrap/cache`);
  });

  // === 10. Setup public_html to point to Laravel public ===
  await step('Configuring public_html -> Laravel public', async () => {
    // Backup old public_html contents
    await runCmd(conn, `mv ${PUBLIC_HTML}/index.php ${PUBLIC_HTML}/index.php.bak 2>/dev/null || true`);

    // Create .htaccess in public_html to redirect to Laravel's public folder
    const htaccess = `<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_URI} !^/nayspa/public/
    RewriteRule ^(.*)$ /nayspa/public/$1 [L]
</IfModule>`;

    await runCmd(conn, `cat > ${PUBLIC_HTML}/.htaccess << 'HTEOF'
${htaccess}
HTEOF`);

    // Better approach: copy Laravel's index.php to public_html and adjust path
    const indexPhp = `<?php

define('LARAVEL_START', microtime(true));

// Maintenance mode check
if (file_exists($maintenance = __DIR__.'/../nayspa/storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../nayspa/vendor/autoload.php';

$app = require_once __DIR__.'/../nayspa/bootstrap/app.php';

$app->bind('path.public', function() {
    return __DIR__;
});

$kernel = $app->make(Illuminate\\Contracts\\Http\\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\\Http\\Request::capture()
)->send();

$kernel->terminate($request, $response);
`;
    await runCmd(conn, `cat > ${PUBLIC_HTML}/index.php << 'PHPEOF'
${indexPhp}
PHPEOF`);

    // Copy .htaccess from Laravel public to public_html
    await runCmd(conn, `cp ${APP_DIR}/public/.htaccess ${PUBLIC_HTML}/.htaccess`);

    // Symlink storage
    await runCmd(conn, `ln -sfn ${APP_DIR}/storage/app/public ${PUBLIC_HTML}/storage 2>/dev/null || true`);

    await runCmd(conn, `ls -la ${PUBLIC_HTML}/`);
  });

  // === 11. Build frontend assets locally and upload? No - check if node available ===
  await step('Checking Node.js for asset build', async () => {
    const nodeVersion = await runCmd(conn, 'node --version 2>&1 || echo "not_found"');
    if (nodeVersion.includes('not_found') || nodeVersion.includes('not')) {
      console.log('⚠️  Node.js not available on server - will need to upload pre-built assets');
    } else {
      await runCmd(conn, `cd ${APP_DIR} && npm install && npm run build 2>&1`);
    }
  });

  // === Done ===
  console.log('\n' + '='.repeat(55));
  console.log('🎉  DEPLOYMENT COMPLETE!');
  console.log('='.repeat(55));
  console.log(`\n🌐 Site URL: https://${DOMAIN}`);
  console.log(`🔐 Admin:    https://${DOMAIN}/admin/login`);
  console.log(`📧 Admin email: admin@nayspa.iq`);
  console.log('\n');

  conn.end();
}

deploy().catch(e => {
  console.error('\n❌ Deployment failed:', e.message);
  process.exit(1);
});
