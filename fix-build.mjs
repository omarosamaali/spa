import { Client } from 'ssh2';
import SftpClient from 'ssh2-sftp-client';

const SSH = {
  host: '92.113.24.42',
  port: 65002,
  username: 'u133574193',
  password: 'o1m2r3e4l5Q!1',
  readyTimeout: 60000,
};

const PUB = '/home/u133574193/domains/smartbookiq.com/public_html';
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

  // Check current state
  console.log('--- Current public_html/build contents ---');
  await run(conn, `ls -la ${PUB}/build/ 2>/dev/null`);
  await run(conn, `ls -la ${PUB}/build/assets/ 2>/dev/null || echo "no assets dir"`);
  await run(conn, `cat ${PUB}/build/manifest.json 2>/dev/null || echo "no manifest"`);

  console.log('\n--- Current nayspa/public/build contents ---');
  await run(conn, `ls -la ${APP}/public/build/assets/`);
  await run(conn, `cat ${APP}/public/build/manifest.json`);

  // Fix: remove old build and copy fresh
  console.log('\n--- Fixing build directory ---');
  await run(conn, `rm -rf ${PUB}/build`);
  await run(conn, `cp -r ${APP}/public/build ${PUB}/build`);
  console.log('Copied!');

  // Verify
  console.log('\n--- Verify new build ---');
  await run(conn, `ls -la ${PUB}/build/assets/`);
  await run(conn, `cat ${PUB}/build/manifest.json`);

  // Clear Laravel cache
  await run(conn, `cd ${APP} && php artisan optimize 2>&1`);

  // Test
  const status = await run(conn, `curl -sk -o /dev/null -w "%{http_code}" https://smartbookiq.com/`);
  console.log(`\nHTTP Status: ${status.trim()}`);

  console.log('\n✅ Build directory fixed!');
  conn.end();
}

main().catch(e => console.error('Error:', e.message));
