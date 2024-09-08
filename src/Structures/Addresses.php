<?php

declare(strict_types=1);

namespace Evt\Imap\Structures;

use Evt\Imap\Structures\Address;
use Evt\Util\Stack;

final class Addresses extends Stack
{
    public function push(Address $address)
    {
        array_push($this->array, $address);
    }

    public function pop(): Address
    {
        return array_pop($this->array);
    }
}
