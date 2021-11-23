<?php declare(strict_types=1);

namespace Evt\Imap\Config;

/**
 * Used to specify connection info
 *
 * @author Eelke van Turnhout <eelketurnhout3@gmail.com>
 * @version 1.0
 */
class Connection
{
    use Traits\UsesSslTrait;

    /**
     * The host
     *
     * @var string
     */
    protected $host;

    /**
     * The port to connect to
     *
     * @var int
     */
    protected $port;

    /**
     * @param string    $host   The host to connect to
     * @param int       $port   The port to connect to
     * @param bool      $ssl    Specify if the connection is over ssl
     */
    public function __construct(string $host, int $port, bool $ssl)
    {
        $this->setHost($host);
        $this->setPort($port);
        $this->usesSsl($ssl);
    }

    /**
     * Set the host
     *
     * @param string $host The host to connect to
     */
    public function setHost(string $host) : void
    {
        $this->host = $host;
    }

    /**
     * Get the host
     *
     * @return The host as a string
     */
    public function getHost() : string
    {
        return $this->host;
    }

    /**
     * Set the port
     *
     * @param int $port The port to connect to
     */
    public function setPort(int $port) : void
    {
        $this->port = $port;
    }

    /**
     * Get the port
     *
     * @return The port as an integer
     */
    public function getPort() : int
    {
        return $this->port;
    }
}