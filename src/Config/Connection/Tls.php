<?php

declare(strict_types=1);

namespace Evt\Imap\Config\Connection;

final class Tls implements ProtocolInterface
{
    public function name(): string
    {
        return 'tls';
    }
}
