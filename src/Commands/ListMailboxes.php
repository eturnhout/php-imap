<?php

declare(strict_types=1);

namespace Evt\Imap\Commands;

use Evt\Imap\Helpers\Input\InputInterface;
use Evt\Imap\Parsers\ParserInterface;

/**
 * Get a list of mailboxes and the hierarchy delimiter
 * Runs the LIST command described at https://www.rfc-editor.org/rfc/rfc3501.html#section-6.3.8
 */
class ListMailboxes extends AbstractCommand implements CommandInterface
{
    public function __construct(
        protected ?InputInterface $referenceName,
        protected ?InputInterface $mailboxName,
    ) {}

    public function getCommand(): string
    {
        $referenceName = $this->referenceName ? $this->referenceName->getInput() : '';
        $mailboxName = $this->mailboxName ? $this->mailboxName->getInput() : '*';

        return 'LIST "' . $referenceName . '" "' . $mailboxName . '"';
    }

    public function getParser(): ParserInterface
    {
        return new \Evt\Imap\Parsers\ListMailboxes();
    }
}
