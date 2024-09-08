<?php

declare(strict_types=1);

namespace Evt\Imap\Structures\Body;

use Evt\Util\Stack;

final class InfoStack extends Stack
{
    public function push(AbstractInfo $info)
    {
        array_push($this->array, $info);
    }

    public function pop(): AbstractInfo
    {
        return array_pop($this->array);
    }
}
