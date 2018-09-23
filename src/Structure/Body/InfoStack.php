<?php
namespace Evt\Imap\Structure\Body;

use Evt\Imap\Structure\Body\AbstractInfo;

use Evt\Util\Stack;

/**
 * Evt\Imap\Structure\Body\InfoStack
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
     * @param Evt\Imap\Structure\Body\AbstractInfo $info A AbstractInfo object
     */
    public function push(AbstractInfo $info)
    {
        array_push($this->array, $info);
    }

    /**
     * Pop a AbstractInfo object from the stack
     *
     * @return Evt\Imap\Structure\Body\AbstractInfo
     */
    public function pop()
    {
        return array_pop($this->array);
    }
}
