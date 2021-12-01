<?php
namespace Evt\Imap\Config;

use Evt\Util\Validator as Validate;

/**
 * AbstractConfig
 *
 * Abstract configuration class for clients that need some sort of authentication
 *
 *
 * @author Eelke van Turnhout <eelketurnhout3@gmail.com>
 * @version 1.0
 */
class AbstractConfig
{
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
     * The username
     *
     * @var string
     */
    protected $username;

    /**
     * The user's password or access token
     * Avoid using passwords for obvious security risks
     *
     * @var string
     */
    protected $key;

    /**
     *
     * @param string    $host       The host to connect to
     * @param int       $port       The port to connect to
     * @param string    $username   The username to use to login with
     * @param string    $key        Password or access token to use when login in
     */
    public function __construct($host, $port, $username, $key)
    {
        $this->setHost($host);
        $this->setPort($port);
        $this->setUsername($username);
        $this->setKey($key);
    }

    /**
     * Set the host
     *
     * @param string $host The host to connect to
     *
     * @throws \InvalidArgumentException When the host is not a non empty string
     */
    public function setHost($host)
    {
        Validate::nonEmptyString("host", $host, __METHOD__);
        $this->host = $host;
    }

    /**
     * Get the host
     *
     * @return The host as a string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Set the port
     *
     * @param int $port The port to connect to
     *
     * @throws \InvalidArgumentException When the port isn't a integer
     */
    public function setPort($port)
    {
        Validate::integer("port", $port, __METHOD__);
        $this->port = $port;
    }

    /**
     * Get the port
     *
     * @return The port as an integer
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * Set the username
     *
     * @param string $username The username used to login with
     *
     * @throws \InvalidArgumentException When the username is not a non empty string
     */
    public function setUsername($username)
    {
        Validate::nonEmptyString("username", $username, __METHOD__);
        $this->username = $username;
    }

    /**
     * Set the username
     *
     * @return The username as a string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the user's key (password/access token)
     *
     * @param string $key The password or access token to login with
     *
     * @throws \InvalidArgumentException When the key is not a non empty string
     */
    public function setKey($key)
    {
        Validate::nonEmptyString("password/token", $key, __METHOD__);
        $this->key = $key;
    }

    /**
     * Get the user's key (password/access token)
     *
     * @return The password or access token as a string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set whether or not to use ssl
     *
     * @param boolean $ssl True of False
     *
     * @throws \InvalidArgumentException When ssl is a non boolean value
     */
    public function setSsl($ssl)
    {
        Validate::boolean("ssl", $ssl, __METHOD__);
        $this->ssl = $ssl;
    }

    /**
     * Check if ssl is set
     *
     * @return boolean
     */
    public function isSsl()
    {
        return $this->ssl;
    }

    /**
     * Set whether or not to use oauth
     *
     * @param boolean $oauth True or false
     *
     * @throws \InvalidArgumentException When oauth is a non boolean value
     */
    public function setOauth($oauth)
    {
        Validate::boolean("oauth", $oauth, __METHOD__);
        $this->oauth = $oauth;
    }

    /**
     * Check if the configuration is set to use oauth
     *
     * @return boolean
     */
    public function isOauth()
    {
        return $this->oauth;
    }
}
