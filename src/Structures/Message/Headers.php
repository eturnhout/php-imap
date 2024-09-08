<?php

declare(strict_types=1);

namespace Evt\Imap\Structures\Message;

use Evt\Util\Stack;

final class HeaderStack extends Stack
{
    public function push(Header $header)
    {
        array_push($this->array, $header);
    }

    public function pop(): Header
    {
        return array_pop($this->array);
    }
}
