<?php declare(strict_types=1);

namespace Evt\Imap\Config\Connection;

use Evt\Imap\Config\ConnectionProtocolInterface;

class Tls implements ProtocolInterface
{
    public function name(): string
    {
        return 'tls';
    }
}
