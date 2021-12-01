<?php declare(strict_types=1);

namespace Evt\Imap\Parsers;

class ListMailboxes implements ParserInterface
{
    public function parse(string $string)
    {
        if ( ! $string) {
            throw new \Exception(__METHOD__ . '; Unable to list the mailboxes.');
        }

        // Get the delimiter
        $delimiterPos = strpos($string, "\"") + 1;
        $delimiter = substr($string, $delimiterPos, 1);

        $lines = explode("\r\n", $string);
        $mailboxes = array();
        $mailboxes["delimiter"] = $delimiter;
        $needle = "\" ";

        foreach ($lines as $line) {
            $mailbox = str_replace("\"", "", substr($line, strpos($line, $needle), strlen($line)));
            $mailboxes[] = trim($mailbox);
        }

        return $mailboxes;
    }
}
