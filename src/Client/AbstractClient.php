<?php declare(strict_types=1);

namespace Evt\Imap\Client;

use Evt\Imap\Config;

/**
 * AbstractClient
 *
 * Class that with base client functions
 *
 * @author Eelke van Turnhout <eelketurnhout3@gmail.com>
 * @version 1.0
 */
abstract class AbstractClient
{
    private $config;

    public function __construct(Config $config)
    {
        $this->setConfig($config);
    }

    /**
     * Set the configurations
     *
     * @param \Evt\Imap\Config $config The configurations with credentials
     */
    public function setConfig(Config $config) : void
    {
        $this->config = $config;
    }

    /**
     * Get the configurations
     *
     * @return Evt\Imap\Config
     */
    public function getConfig() : Config
    {
        return $this->config;
    }

    /**
     * Connect to the server
     */
    abstract public function connect();

    /**
     * Disconnect from the server
     */
    abstract public function disconnect();
}
