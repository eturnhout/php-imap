<?php
namespace Evt\Imap;

use Evt\Imap\Config\AbstractConfig;

/**
 * Evt\Imap\Config
 *
 * Configurations for imap interactions
 *
 * @author Eelke van Turnhout <eelketurnhout3@gmail.com>
 * @version 1.0
 */
class Config extends AbstractConfig
{
    use \Evt\Imap\Config\Traits\UsesOauthTrait, \Evt\Imap\Config\Traits\UsesSslTrait;

    /**
     * Evt\Imap\Config
     *
     * @param string    $host       The host to connect to
     * @param int       $port       The port to connect to
     * @param string    $username   The username to use to login with
     * @param string    $key        Password or access token to use when login in
     * @param boolean   $ssl        Whether or not the connection is made via ssl (Secure Sockets Layer)
     * @param boolean   $oauth      Whether or not it uses oauth to grant access
     */
    public function __construct($host, $port, $username, $key, $ssl, $oauth)
    {
        parent::__construct($host, $port, $username, $key);
        $this->usesSsl($ssl);
        $this->usesOauth($oauth);
    }
}
