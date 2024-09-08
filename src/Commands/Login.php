<?php

declare(strict_types=1);

namespace Evt\Imap\Commands;

use Evt\Imap\Config\Credentials;
use Evt\Imap\Config\Login\XOauth2;
use Evt\Imap\Config\Login\Plain;
use Evt\Imap\Parsers\ParserInterface;

final class Login extends AbstractCommand implements CommandInterface
{
    public function __construct(
        private Credentials $credentialsConfig
    ) {}

    public function getCommand(): string
    {
        $credentialsConfig = $this->credentialsConfig;
        $loginType = $credentialsConfig->getLoginType();

        if ($loginType instanceof XOauth2) {
            return "AUTHENTICATE XOAUTH2 " . base64_encode("user=" . $credentialsConfig->getUsername() . "\1auth=Bearer " . $credentialsConfig->getKey() . "\1\1");
        } else if ($loginType instanceof Plain) {
            return "LOGIN " . $credentialsConfig->getUsername() . " " . $credentialsConfig->getKey();
        }
    }

    public function getParser(): ParserInterface
    {
        return new \Evt\Imap\Parsers\Login();
    }
}
