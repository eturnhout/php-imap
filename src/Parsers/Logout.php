<?php

declare(strict_types=1);

namespace Evt\Imap\Parsers;

use Evt\Imap\Structures\Logout as LogoutStructure;

class Logout implements ParserInterface
{
    public function parse(string $string): LogoutStructure
    {
        return new LogoutStructure($string);
    }
}
