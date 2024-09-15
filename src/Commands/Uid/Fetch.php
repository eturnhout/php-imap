<?php

declare(strict_types=1);

namespace Evt\Imap\Commands\Uid;

use Evt\Imap\Commands\AbstractCommand;
use Evt\Imap\Commands\CommandInterface;
use Evt\Imap\Helpers\Input\InputInterface;

final class Fetch extends AbstractCommand implements CommandInterface
{
    public function __construct(
        private InputInterface $input
    ) {}

    public function getCommand(): string
    {
        return 'UID FETCH ' . $this->input->getInput();
    }

    public function getParser(): \Evt\Imap\Parsers\ParserInterface
    {
        return new \Evt\Imap\Parsers\Uid\Fetch();
    }
}
