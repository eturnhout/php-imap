<?php

namespace Evt\Imap\Structures;

use Evt\Imap\Structures\Address;
use Evt\Util\Stack;

/**
 * Evt\Imap\Structure\Addresses
 *
 * A stack for address objects
 *
 * @author Eelke van Turnhout <eelketurnhout3@gmail.com>
 * @version 1.0
 */
class Addresses extends Stack
{
    /**
     * Push a Address object onto the stack.
     *
     * @param Evt\Imap\Structure\Address $address
     */
    public function push(Address $address)
    {
        array_push($this->array, $address);
    }

    /**
     * Pop a Address object from the stack
     *
     * @return Evt\Imap\Structure\Address
     */
    public function pop()
    {
        return array_pop($this->array);
    }
}
