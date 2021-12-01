<?php declare(strict_types=1);

namespace Evt\Imap\Commands;

interface CommandInterface
{
    public function getCommand(): string;
    public function getParser(): \Evt\Imap\Parsers\ParserInterface;
}
