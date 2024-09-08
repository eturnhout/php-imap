<?php

declare(strict_types=1);

namespace Evt\Imap\Commands;

use Evt\Imap\Parsers\Logout as LogoutParser;

class Logout extends AbstractCommand implements CommandInterface
{
    public function getCommand(): string
    {
        return 'LOGOUT';
    }

    public function getParser(): LogoutParser
    {
        return new LogoutParser;
    }
}
