<?php
namespace Evt\Imap\Structure\Body;

use Evt\Imap\Structure\Body\Part;

use Evt\Util\Stack;

class PartStack extends Stack
{

    public function push(Part $part)
    {
        array_push($this->array, $part);
    }

    public function pop()
    {
        return array_pop($this->array);
    }
}
