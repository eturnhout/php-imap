<?php

declare(strict_types=1);

namespace Evt\Imap\Config\Login;

final class XOauth2 implements TypeInterface
{
    public function name(): string
    {
        return "XOAUTH2";
    }
}
