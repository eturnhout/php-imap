<?php declare(strict_types=1);

namespace Evt\Imap\Config;

/**
 * Used to specify credential info
 *
 * @author Eelke van Turnhout <eelketurnhout3@gmail.com>
 * @version 1.0
 */
class Credentials
{
    use Traits\UsesOauthTrait;

    /**
     * The username
     *
     * @var string
     */
    protected $username;

    /**
     * The user's password or access token
     *
     * @var string
     */
    protected $key;

    /**
     * @param string    $username   The username to use to login with
     * @param string    $key        Password or access token to use when login in
     * @param bool      $oauth      Whether or not it uses oauth to grant access
     */
    public function __construct(string $username, string $key, bool $oauth)
    {
        $this->setUsername($username);
        $this->setKey($key);
        $this->usesOauth($oauth);
    }

    /**
     * Set the username
     *
     * @param string $username The username used to login with
     */
    public function setUsername(string $username) : void
    {
        $this->username = $username;
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
     * Set the user's key (password/access token)
     *
     * @param string $key The password or access token to login with
     */
    public function setKey(string $key) : void
    {
        $this->key = $key;
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
}
