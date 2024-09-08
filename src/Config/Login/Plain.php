<?php

declare(strict_types=1);

namespace Evt\Imap\Config\Login;

final class Plain implements TypeInterface
{
    public function name(): string
    {
        return "PLAIN";
    }
}
