<?php

declare(strict_types=1);

namespace Evt\Imap;

use Evt\Imap\Config\Connection as ConnectionConfig;
use Evt\Imap\Config\Credentials as CredentialsConfig;;

class Config
{
    public function __construct(
        private ConnectionConfig $connectionConfig,
        private CredentialsConfig $credentialsConfig,
    ) {}

    public function getConnectionConfig(): ConnectionConfig
    {
        return $this->connectionConfig;
    }

    public function getCredentialsConfig(): CredentialsConfig
    {
        return $this->credentialsConfig;
    }
}
