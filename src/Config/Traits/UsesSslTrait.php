<?php declare(strict_types=1);

namespace Evt\Imap\Config\Traits;

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
     * @var bool
     */
    protected $ssl;

    /**
     * Getter/setter function
     *
     * @param bool $ssl (optional) Leave empty to get the value or pass a boolean to set the value
     *
     * @return bool Returns the current status of the ssl property
     */
    public function usesSsl(?bool $ssl = null) : bool
    {
        if ( ! is_null($ssl)) {
            $this->ssl = $ssl;
        }

        return (bool) $this->ssl;
    }
}
