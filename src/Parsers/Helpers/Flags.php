<?php

declare(strict_types=1);

namespace Evt\Imap\Parsers\Helpers;

class Flags
{
    /**
     * Parses the flags part of the response
     */
    public static function parse(string $flags): array
    {
        $flagsStart = strpos($flags, "FLAGS (") + strlen("FLAGS (");
        $flagsEnd = strpos($flags, ")");
        $flags = str_replace("\\", "", substr($flags, $flagsStart, $flagsEnd - $flagsStart));

        if (strlen($flags) == 0) {
            return array();
        }

        return explode(" ", $flags) ?: [];
    }
}
