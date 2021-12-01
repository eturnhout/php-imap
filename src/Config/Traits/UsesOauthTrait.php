<?php
namespace Evt\Imap\Config\Traits;

use Evt\Util\Validator as Validate;

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
     * @var boolean
     */
    protected $oauth;

    /**
     * Getter/setter function
     *
     * @param boolean $oauth (optional) Leave empty to get the value or pass a boolean to set the value (also returns it)
     *
     * @return boolean Returns the current status of the oauth property
     *
     * @throws \InvalidArgumentException When the oauth param is passed as a non boolean value
     */
    public function usesOauth($oauth = null)
    {
        if (! is_null($oauth)) {
            Validate::boolean("oauth", $oauth, __METHOD__);
            $this->oauth = $oauth;
        }

        return (bool) $this->oauth;
    }
}
