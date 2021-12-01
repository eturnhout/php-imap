<?php
namespace Evt\Imap\Config\Traits;

use Evt\Util\Validator as Validate;

/**
 * UsesSslTrait
 *
 * Trait that adds a usesSsl function
 *
 * @author Eelke van Turnhout <eelketurnhout3@gmail.com>
 * @version 1.0
 */
trait UsesSslTrait
{
    /**
     * Used to track whether or not ssl is used
     *
     * @var boolean
     */
    protected $ssl;

    /**
     * Getter/setter function
     *
     * @param boolean $ssl (optional) Leave empty to get the value or pass a boolean to set the value (also returns it)
     *
     * @return boolean Returns the current status of the ssl property
     *
     * @throws \InvalidArgumentException When the ssl param is passed as a non boolean value
     */
    public function usesSsl($ssl = null)
    {
        if (! is_null($ssl)) {
            Validate::boolean("ssl", $ssl, __METHOD__);
            $this->ssl = $ssl;
        }

        return (bool) $this->ssl;
    }
}
