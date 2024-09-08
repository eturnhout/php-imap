<?php

declare(strict_types=1);

namespace Evt\Imap\Config\Connection;

final class Ssl implements ProtocolInterface
{
    public function name(): string
    {
        return 'ssl';
    }
}
