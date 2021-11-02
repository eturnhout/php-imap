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
        $start = strpos($content, "}") + 1;
        $length = strlen($content) - $start + 1;

        if ((strrpos($content, "UID") - $length > 0) && (strrpos($content, "UID") - $length < 5)) { // Sometimes the uid is at the end of the response. @TODO find a better way to remove this if possible.
            $cleanContent = substr($content, $start, $length);
            $lastUidPosition = strrpos($cleanContent, "UID");
            $cleanContent = trim(substr($cleanContent, 0, $lastUidPosition));
        } else {
            $cleanContent = trim(substr($content, $start, $length), ")");
        }

        return $cleanContent;
    }
}
