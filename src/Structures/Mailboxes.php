<?php

declare(strict_types=1);

namespace Evt\Imap\Structures;

final class Mailboxes implements StructureInterface
{
    public function __construct(
        private string $delimiter,
        private array $mailboxes
    ) {}

    public function getDelimiter()
    {
        return $this->delimiter;
    }

    public function getMailboxes()
    {
        return $this->mailboxes;
    }
}
