<?php declare(strict_types=1);

namespace Evt\Imap\Parsers;

interface ParserInterface
{
    public function parse(string $string) : \Evt\Imap\Structures\StructureInterface;
}
