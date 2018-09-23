<?php
namespace Evt\Imap\Structure\Message;

use Evt\Imap\Structure\Message\Header;

use Evt\Util\Stack;

/**
 * Evt\Imap\Structure\Message\HeaderStack
 *
 * A stack to fill with Header objects
 *
 * @author Eelke van Turnhout <eelketurnhout3@gmail.com>
 * @version 1.0
 */
class HeaderStack extends Stack
{

    /**
     * Push a Header object onto the stack
     *
     * @param Evt\Imap\Structure\Message\Header $header The MessageHeader object to push onto the stack
     */
    public function push(Header $header)
    {
        array_push($this->array, $header);
    }

    /**
     * Pop a Header object from the stack
     *
     * @return Evt\Imap\Structure\Message\Header
     */
    public function pop()
    {
        return array_pop($this->array);
    }
}
