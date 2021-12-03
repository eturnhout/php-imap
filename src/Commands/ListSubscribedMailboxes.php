<?php declare(strict_types=1);

namespace Evt\Imap\Commands;

/**
 * Get a list of subscribed mailboxes and the hierarchy delimiter
 * Runs the LSUB command described in rfc3501#section-6.3.9
 */
class ListSubscribedMailboxes extends ListMailboxes
{
    public function getCommand(): string
    {
        $referenceName = $this->referenceName ? $this->referenceName->getInput() : '';
        $mailboxName = $this->mailboxName ? $this->mailboxName->getInput() : '*';

        return 'LSUB "' . $referenceName . '" "' . $mailboxName . '"';
    }
}
