<?php

declare(strict_types=1);

namespace Evt\Imap\Parsers;

use Evt\Imap\Structures\StructureInterface;

final class Login implements ParserInterface
{
    public function parse(string $string): StructureInterface
    {
        return new \Evt\Imap\Structures\Login($string);
    }
}
