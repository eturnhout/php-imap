<?php declare(strict_types=1);

namespace Evt\Imap;

use Evt\Imap\Config\Connection as ConnectionConfig;
use Evt\Imap\Config\Credentials as CredentialsConfig;;

/**
 * Evt\Imap\Config
 *
 * Configuration for imap interactions
 *
 * @author Eelke van Turnhout <eelketurnhout3@gmail.com>
 * @version 1.0
 */
class Config
{
    /**
     * @var \Evt\Imap\Config\Connection
     */
    private $connectionConfig;

    /**
     * @var \Evt\Imap\Config\Credentials
     */
    private $credentialsConfig;

    /**
     * Evt\Imap\Config
     *
     * @param \Evt\Imap\Config\Connection
     * @param \Evt\Imap\Config\Credentials
     */
    public function __construct(ConnectionConfig $connectionConfig, CredentialsConfig $credentialsConfig)
    {
        $this->setConnectionConfig($connectionConfig);
        $this->setCredentialsConfig($credentialsConfig);
    }

    public function setConnectionConfig(ConnectionConfig $connectionConfig) : void
    {
        $this->connectionConfig = $connectionConfig;
    }

    public function getConnectionConfig() : ConnectionConfig
    {
        return $this->connectionConfig;
    }

    public function setCredentialsConfig(CredentialsConfig $credentialsConfig) : void
    {
        $this->credentialsConfig = $credentialsConfig;
    }

    public function getCredentialsConfig() : CredentialsConfig
    {
        return $this->credentialsConfig;
    }
}
