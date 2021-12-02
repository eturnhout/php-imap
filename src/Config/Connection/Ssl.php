<?php declare(strict_types=1);

namespace Evt\Imap\Config\Connection;

use Evt\Imap\Config\ConnectionProtocolInterface;

class Ssl implements ProtocolInterface
{
    public function name(): string
    {
        return 'ssl';
    }
}
