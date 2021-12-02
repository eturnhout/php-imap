<?php declare(strict_types=1);

namespace Evt\Imap\Config;

use Evt\Imap\Config\Connection\ProtocolInterface;

/**
 * Used to specify connection info
 *
 * @author Eelke van Turnhout <eelketurnhout3@gmail.com>
 * @version 1.0
 */
final class Connection
{
    /**
     * The host
     *
     * @var string
     */
    private $host;

    /**
     * The port to connect to
     *
     * @var int
     */
    private $port;

    /**'
     * @var ProtocolInterface
     */
    private $protocol;

    /**
     * @param string            $host       The host to connect to
     * @param int               $port       The port to connect to
     * @param ProtocolInterface $protocol   Specify the connection protocol
     */
    public function __construct(string $host, int $port, ProtocolInterface $protocol)
    {
        $this->host = $host;
        $this->port = $port;
        $this->protocol = $protocol;
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
     * Get the port
     *
     * @return The port as an integer
     */
    public function getPort() : int
    {
        return $this->port;
    }

    public function getProtocol(): ProtocolInterface
    {
        return $this->protocol;
    }
}
