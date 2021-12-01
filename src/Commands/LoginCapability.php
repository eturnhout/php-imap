<?php declare(strict_types=1);

namespace Evt\Imap\Commands;

class LoginCapability extends AbstractCommand implements CommandInterface
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
