<?php

declare(strict_types=1);

namespace Evt\Imap\Config\Connection;

interface ProtocolInterface
{
    public function name(): string;
}
