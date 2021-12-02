<?php declare(strict_types=1);

namespace Evt\Imap\Commands;

class ListSubscribedMailboxes extends ListMailboxes
{
    public function getCommand(): string
    {
        return 'LSUB "' . $this->getReferenceName() . '" "' . $this->getMailboxName() . '"';
    }
}
