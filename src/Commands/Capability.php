<?php

declare(strict_types=1);

namespace Evt\Imap\Commands;

final class Capability extends AbstractCommand implements CommandInterface
{
    public function getCommand(): string
    {
        return 'CAPABILITY';
    }

    public function getParser(): \Evt\Imap\Parsers\ParserInterface
    {
        return new \Evt\Imap\Parsers\Capability();
    }
}
