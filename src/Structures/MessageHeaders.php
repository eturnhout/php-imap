<?php declare(strict_types=1);

namespace Evt\Imap\Structures;

use Evt\Imap\Structures\Message\Header as MessageHeader;
use Evt\Util\Stack;

/**
 * Evt\Imap\Structures\MessageHeaders
 *
 * A stack to fill with Header objects
 *
 * @author Eelke van Turnhout <eelketurnhout3@gmail.com>
 * @version 1.0
 */
class MessageHeaders extends Stack implements StructureInterface
{
    /**
     * Push a Header object onto the stack
     *
     * @param \Evt\Imap\Structures\Message\Header $header The MessageHeader object to push onto the stack
     */
    public function push(MessageHeader $header)
    {
        array_push($this->array, $header);
    }

    /**
     * Pop a Header object from the stack
     *
     * @return Evt\Imap\Structures\Message\Header
     */
    public function pop() : MessageHeader
    {
        return array_pop($this->array);
    }
}
