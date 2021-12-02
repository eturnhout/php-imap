<?php declare(strict_types=1);

namespace Evt\Imap\Commands;

use Evt\Imap\Config\Credentials;
use Evt\Imap\Config\Login\XOauth2;
use Evt\Imap\Config\Login\Plain;
use Evt\Imap\Parsers\ParserInterface;

class Login extends AbstractCommand implements CommandInterface
{
    private $credentialsConfig;

    public function __construct(Credentials $credentialsConfig)
    {
        $this->credentialsConfig = $credentialsConfig;
    }

    public function getCommand(): string
    {
        $credentialsConfig = $this->credentialsConfig;
        $loginType = $credentialsConfig->getLoginType();

        if ($loginType instanceof XOauth2) {
            $credentials = base64_encode("user=" . $credentialsConfig->getUsername() . "\1auth=Bearer " . $credentialsConfig->getKey() . "\1\1");
            return "AUTHENTICATE XOAUTH2 " . $credentials;
        } else if ($loginType instanceof Plain) {
            $credentials = $credentialsConfig->getUsername() . " " . $credentialsConfig->getKey();
            return "LOGIN " . $credentials;
        }
    }

    public function getParser(): ParserInterface
    {
        return new \Evt\Imap\Parsers\Login();
    }
}
