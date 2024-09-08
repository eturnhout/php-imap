<?php

declare(strict_types=1);

namespace Evt\Imap\Structures;

use Evt\Imap\Helpers\Utf7ImapToUtf8;

final class Mailbox implements StructureInterface
{
    public function __construct(
        private string $name,
        private int $uidvalidity,
        private int $exists,
        private int $recent,
        private int $uidnext
    ) {}

    public function getName(): string
    {
        return Utf7ImapToUtf8::convert($this->name);
    }

    public function getUidvalidity(): int
    {
        return $this->uidvalidity;
    }

    public function getExists(): int
    {
        return $this->exists;
    }

    public function getRecent(): int
    {
        return $this->recent;
    }

    public function getUidNext(): int
    {
        return $this->uidnext;
    }
}
