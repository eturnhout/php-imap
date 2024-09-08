<?php

declare(strict_types=1);

namespace Evt\Imap\Config;

use Evt\Imap\Config\Connection\ProtocolInterface;

final class Connection
{
    public function __construct(
        private string $host,
        private int $port,
        private ProtocolInterface $protocol,
    ) {}

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    public function getProtocol(): ProtocolInterface
    {
        return $this->protocol;
    }
}
