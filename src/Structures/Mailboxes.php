<?php

namespace Evt\Imap\Structures;

class Mailboxes implements StructureInterface
{
    protected $delimiter;
    protected $mailboxes;

    public function __construct(string $delimiter, array $mailboxes)
    {
        $this->setDelimiter($delimiter)
            ->setMailboxes($mailboxes);
    }

    public function setDelimiter(string $delimiter)
    {
        $this->delimiter = $delimiter;

        return $this;
    }

    public function getDelimiter()
    {
        return $this->delimiter;
    }

    public function setMailboxes(array $mailboxes)
    {
        $this->mailboxes = $mailboxes;

        return $this;
    }

    public function getMailboxes()
    {
        return $this->mailboxes;
    }
}
