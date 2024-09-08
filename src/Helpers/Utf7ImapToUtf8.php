<?php

declare(strict_types=1);

namespace Evt\Imap\Helpers;

final class Utf7ImapToUtf8
{
    public static function convert(string $string): string
    {
        return mb_convert_encoding($string, "UTF-8", "UTF7-IMAP");
    }
}
