# php-imap
A pure php imap implementation. No need for the php imap extension. (work in progress)

## Examples
### Creating the client instance
<pre>
$host = '{host}';
$port = 993;
$ssl = true;

$username = '{your_email_address}';
$key = '{your_password_or_acces_token}';
$oauth = true; // or false for plain password

$connectionConfig = new ConnectionConfig($host, $port, $ssl);
$credentialsConfig = new CredentialsConfig($username, $key, $oauth);
$imapConfig = new ImapConfig($connectionConfig, $credentialsConfig);

$client = new Client($imapConfig);
</pre>
