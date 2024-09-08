<?php

declare(strict_types=1);

namespace Evt\Imap\Structures;

use Evt\Imap\Config\Login\TypeInterface as LoginType;
use Evt\Util\Stack;

final class CapabilityStack extends Stack implements StructureInterface
{
    public function push(LoginType $loginType): void
    {
        $this->array[$loginType->name()] = $loginType;
    }

    public function has(LoginType $loginType): bool
    {
        return isset($this->array[$loginType->name()]);
    }
}
