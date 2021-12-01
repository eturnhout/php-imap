<?php declare(strict_types=1);

namespace Evt\Imap\Parsers;

class ListMailboxes implements ParserInterface
{
    public function parse(string $string) : \Evt\Imap\Structures\Mailboxes
    {
        if ( ! $string) {
            throw new \Exception(__METHOD__ . '; Unable to list the mailboxes.');
        }

        // Get the delimiter
        $delimiterPos = strpos($string, "\"") + 1;
        $delimiter = substr($string, $delimiterPos, 1);

        $lines = explode("\r\n", $string);
        $mailboxes = array();
        $needle = "\" ";

        foreach ($lines as $line) {
            $mailbox = str_replace("\"", "", substr($line, strpos($line, $needle), strlen($line)));
            $mailboxes[] = trim($mailbox);
        }

        return new \Evt\Imap\Structures\Mailboxes($delimiter, $mailboxes);
    }
}
