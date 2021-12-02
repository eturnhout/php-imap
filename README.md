# php-imap
A pure php imap implementation. No need for the php imap extension. (work in progress)

## Examples
### Creating the client instance
<pre>
use Evt\Imap\Client;
use Evt\Imap\Config as ImapConfig;
use Evt\Imap\Config\Connection as ConnectionConfig;
use Evt\Imap\Config\Credentials as CredentialsConfig;

$host = '{host}';
$port = 993;
$protocol = new \Evt\Imap\Config\Connection\Ssl(); // Tsl also available

$username = '{your_email_address}';
$key = '{your_password_or_acces_token}';
$loginType = new \Evt\Imap\Config\Login\Plain(); // See Config/Login for alternative options

$connectionConfig = new ConnectionConfig($host, $port, $protocol);
$credentialsConfig = new CredentialsConfig($username, $key, $loginType);
$imapConfig = new ImapConfig($connectionConfig, $credentialsConfig);

$client = new Client($imapConfig);
</pre>
