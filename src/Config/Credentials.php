<?php

declare(strict_types=1);

namespace Evt\Imap\Config;

use Evt\Imap\Config\Login\TypeInterface as LoginType;

final class Credentials
{
    public function __construct(
        private string $username,
        private string $key,
        private LoginType $loginType,
    ) {}

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getLoginType(): LoginType
    {
        return $this->loginType;
    }
}
