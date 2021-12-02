<?php declare(strict_types=1);

namespace Evt\Imap\Config\Login;

class Plain implements TypeInterface
{
    public function name(): string
    {
        return "PLAIN";
    }
}
