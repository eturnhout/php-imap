<?php

declare(strict_types=1);

namespace Evt\Imap\Structures;

final class Address
{
    public function __construct(
        private string $name,
        private string $domain,
        private string $mailbox,
        private string $host
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getDomain(): string
    {
        return $this->domain;
    }

    public function getMailbox(): string
    {
        return $this->mailbox;
    }

    public function getHost(): string
    {
        return $this->host;
    }
}
