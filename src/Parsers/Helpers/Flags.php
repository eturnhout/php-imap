<?php declare(strict_types=1);

namespace Evt\Imap\Parsers\Helpers;

class Flags
{
    /**
     * Parses the flags part of the response
     *
     * @param string $flags String with the flags part of the response
     *
     * @return array A array with the flags
     */
    public static function parse(string $flags) : array
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
