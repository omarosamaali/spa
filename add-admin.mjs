import { Client } from 'ssh2';

const SSH = {
  host: '92.113.24.42',
  port: 65002,
  username: 'u133574193',
  password: 'o1m2r3e4l5Q!1',
  readyTimeout: 30000,
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

  const php = `
use App\\Models\\User;
use Illuminate\\Support\\Facades\\Hash;

User::firstOrCreate(
  ['email' => 'omar@gmail.com'],
  [
    'name'     => 'عمر',
    'password' => Hash::make('Omar@2024!'),
    'email_verified_at' => now(),
  ]
);
echo "Done!";
`;

  await run(conn, `cd ${APP} && php artisan tinker --execute="${php.replace(/\n/g,' ').replace(/"/g,'\\"')}" 2>&1`);

  conn.end();
}

main().catch(e => console.error('Error:', e.message));
