import SftpClient from 'ssh2-sftp-client';

const SSH = {
  host: '92.113.24.42',
  port: 65002,
  username: 'u133574193',
  password: 'o1m2r3e4l5Q!1',
};

const PUB = '/home/u133574193/domains/smartbookiq.com/public_html';
const APP = '/home/u133574193/domains/smartbookiq.com/nayspa';

const indexPhp = `<?php

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__.'/../nayspa/storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../nayspa/vendor/autoload.php';

$app = require_once __DIR__.'/../nayspa/bootstrap/app.php';

$app->bind('path.public', function() { return __DIR__; });

$kernel = $app->make(Illuminate\\Contracts\\Http\\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\\Http\\Request::capture()
)->send();

$kernel->terminate($request, $response);
`;

async function main() {
  const sftp = new SftpClient();
  await sftp.connect(SSH);
  console.log('SFTP connected!');

  const buf = Buffer.from(indexPhp, 'utf8');
  await sftp.put(buf, `${PUB}/index.php`);
  console.log('✅ index.php uploaded successfully!');

  await sftp.end();
  console.log('Done!');
}

main().catch(e => console.error('Error:', e.message));
