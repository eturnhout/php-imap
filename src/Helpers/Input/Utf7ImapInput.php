<?php

declare(strict_types=1);

namespace Evt\Imap\Helpers\Input;

final class Utf7ImapInput implements InputInterface
{
    public function __construct(
        private string $input
    ) {}

    public function getInput(): string
    {
        return mb_convert_encoding($this->input, "UTF7-IMAP", "UTF-8");
    }
}
