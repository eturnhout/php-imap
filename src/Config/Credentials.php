<?php declare(strict_types=1);

namespace Evt\Imap\Config;

use Evt\Imap\Config\Login\TypeInterface as LoginType;

/**
 * Used to specify credential info
 *
 * @author Eelke van Turnhout <eelketurnhout3@gmail.com>
 * @version 1.0
 */
final class Credentials
{
    /**
     * The username
     *
     * @var string
     */
    private $username;

    /**
     * The user's password or access token
     *
     * @var string
     */
    private $key;

    /**
     * @var \Evt\Imap\Config\Login\TypeInterface
     */
    private $loginType;

    /**
     * @param string    $username   The username to use to login with
     * @param string    $key        Password or access token to use when login in
     * @param LoginType $loginType  The login type to use
     */
    public function __construct(string $username, string $key, LoginType $loginType)
    {
        $this->username = $username;
        $this->key = $key;
        $this->loginType = $loginType;
    }

    /**
     * Set the username
     *
     * @return The username as a string
     */
    public function getUsername() : string
    {
        return $this->username;
    }

    /**
     * Get the user's key (password/access token)
     *
     * @return The password or access token as a string
     */
    public function getKey() : string
    {
        return $this->key;
    }

    public function getLoginType(): LoginType
    {
        return $this->loginType;
    }
}
