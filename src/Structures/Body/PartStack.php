<?php declare(strict_types=1);

namespace Evt\Imap\Structures\Body;

class PartStack extends \Evt\Util\Stack
{
    public function push(Part $part)
    {
        array_push($this->array, $part);
    }

    public function pop() : Part
    {
        return array_pop($this->array);
    }
}
