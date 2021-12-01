<?php declare(strict_types=1);

namespace Evt\Imap\Config\Traits;

/**
 * UsesOauthTrait
 *
 * Trait that adds a usesOauth function
 *
 * @author Eelke van Turnhout <eelketurnhout3@gmail.com>
 * @version 1.0
 */
trait UsesOauthTrait
{
    /**
     * Used to track whether or not oauth is used
     *
     * @var bool
     */
    protected $oauth;

    /**
     * Getter/setter function
     *
     * @param bool $oauth (optional) Leave empty to get the value or pass a boolean to set the value (also returns it)
     *
     * @return bool Returns the current status of the oauth property
     */
    public function usesOauth(?bool $oauth = null) : bool
    {
        if ( ! is_null($oauth)) {
            $this->oauth = $oauth;
        }

        return (bool) $this->oauth;
    }
}
