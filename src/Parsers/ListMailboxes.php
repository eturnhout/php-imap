<?php

declare(strict_types=1);

namespace Evt\Imap\Parsers;

use Exception;

class ListMailboxes implements ParserInterface
{
    public function parse(string $string): \Evt\Imap\Structures\Mailboxes
    {
        if (!$string) {
            throw new Exception(__METHOD__ . '; Unable to list the mailboxes.');
        }

        // Get the delimiter
        $delimiterPos = strpos($string, "\"") + 1;
        $delimiter = mb_substr($string, $delimiterPos, 1);

        $lines = explode("\r\n", $string);
        $mailboxes = array();
        $needle = "\" ";

        foreach ($lines as $line) {
            $mailbox = trim(str_replace("\"", "", substr($line, strpos($line, $needle), strlen($line))));
            $mailboxes[] = mb_convert_encoding($mailbox, "UTF-8", "UTF7-IMAP");
        }

        return new \Evt\Imap\Structures\Mailboxes($delimiter, $mailboxes);
    }
}
