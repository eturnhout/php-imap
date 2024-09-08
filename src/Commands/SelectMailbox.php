<?php

declare(strict_types=1);

namespace Evt\Imap\Commands;

use Evt\Imap\Helpers\Input\InputInterface;
use Evt\Imap\Parsers\ParserInterface;

/**
 * Select a mailbox to interact with
 * This uses the SELECT command described here https://www.rfc-editor.org/rfc/rfc3501.html#section-6.3.1
 */
final class SelectMailbox extends AbstractCommand implements CommandInterface
{
    public function __construct(
        private InputInterface $mailbox
    ) {}

    public function getCommand(): string
    {
        return 'SELECT "' . $this->mailbox->getInput() . '"';
    }

    public function getParser(): ParserInterface
    {
        return new \Evt\Imap\Parsers\SelectMailbox($this->mailbox->getInput());
    }
}
