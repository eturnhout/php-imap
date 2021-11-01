<?php declare(strict_types=1);

namespace Evt\Imap\Structures\Body;

use Evt\Util\Stack;

/**
 * Evt\Imap\Structures\Body\InfoStack
 *
 * A stack for body info objects
 *
 * @author Eelke van Turnhout <eelketurnhout3@gmail.com>
 * @version 1.0
 */
class InfoStack extends Stack
{
    /**
     * Push a AbstractInfo object onto the stack
     *
     * @param \Evt\Imap\Structures\Body\AbstractInfo $info A AbstractInfo object
     */
    public function push(AbstractInfo $info)
    {
        array_push($this->array, $info);
    }

    /**
     * Pop a AbstractInfo object from the stack
     *
     * @return \Evt\Imap\Structures\Body\AbstractInfo
     */
    public function pop() : AbstractInfo
    {
        return array_pop($this->array);
    }
}
