<?php declare(strict_types=1);

namespace Evt\Imap\Parsers;

class GetMessageHeaders implements ParserInterface
{
    public function parse(string $string) : \Evt\Imap\Structures\StructureInterface
    {
        echo $string;
        exit;

        return new \Evt\Imap\Structures\MessageHeaders([]);
    }
}
