<?php

declare(strict_types=1);

namespace Evt\Imap\Commands;

/**
 * Get a list of subscribed mailboxes and the hierarchy delimiter
 * Runs the LSUB command described here https://www.rfc-editor.org/rfc/rfc3501.html#section-6.3.9
 */
final class ListSubscribedMailboxes extends ListMailboxes
{
    public function getCommand(): string
    {
        $referenceName = $this->referenceName ? $this->referenceName->getInput() : '';
        $mailboxName = $this->mailboxName ? $this->mailboxName->getInput() : '*';

        return 'LSUB "' . $referenceName . '" "' . $mailboxName . '"';
    }
}
