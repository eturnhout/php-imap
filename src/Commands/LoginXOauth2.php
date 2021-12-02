<?php declare(strict_types=1);

namespace Evt\Imap\Commands;

use Evt\Imap\Config\Credentials;
use Evt\Imap\Parsers\ParserInterface;

class LoginXOauth2 extends AbstractCommand implements CommandInterface
{
    private $credentialsConfig;

    public function __construct(Credentials $credentialsConfig)
    {
        $this->credentialsConfig = $credentialsConfig;
    }

    public function getCommand(): string
    {
        $credentials = base64_encode("user=" . $this->credentialsConfig->getUsername() . "\1auth=Bearer " . $this->credentialsConfig->getKey() . "\1\1");

        return "AUTHENTICATE XOAUTH2 " . $credentials;
    }

    public function getParser(): ParserInterface
    {
        return new \Evt\Imap\Parsers\Login();
    }
}
