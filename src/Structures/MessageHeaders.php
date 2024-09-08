<?php

declare(strict_types=1);

namespace Evt\Imap\Structures;

use Evt\Imap\Structures\Message\Header as MessageHeader;
use Evt\Util\Stack;

final class MessageHeaders extends Stack implements StructureInterface
{
    public function push(MessageHeader $header)
    {
        array_push($this->array, $header);
    }

    public function pop(): MessageHeader
    {
        return array_pop($this->array);
    }
}
