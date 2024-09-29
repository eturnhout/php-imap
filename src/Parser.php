<?php
namespace Evt\Imap;

/**
 * Evt\Imap\Parser
 *
 * My attempt to parse incoming responses from the Imap class
 *
 * @author Eelke van Turnhout <eelketurnhout3@gmail.com>
 * @version 1.0
 */
class Parser
{
    public static function parseContent($content)
    {
        $start = mb_strpos($content, "}") + 1;
        $length = mb_strlen($content) - $start + 1;

        if ((mb_strrpos($content, "UID") - $length > 0) && (mb_strrpos($content, "UID") - $length < 5)) { // Sometimes the uid is at the end of the response. @TODO find a better way to remove this if possible.
            $cleanContent = mb_substr($content, $start, $length);
            $lastUidPosition = strrpos($cleanContent, "UID");
            $cleanContent = trim(mb_substr($cleanContent, 0, $lastUidPosition));
        } else {
            $cleanContent = trim(mb_substr($content, $start, $length), ")");
        }

        return $cleanContent;
    }
}
