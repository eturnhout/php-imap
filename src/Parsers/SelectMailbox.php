<?php

declare(strict_types=1);

namespace Evt\Imap\Parsers;

final class SelectMailbox implements ParserInterface
{
    public function __construct(
        private string $mailbox
    ) {}

    public function parse(string $string): \Evt\Imap\Structures\Mailbox
    {
        $lines = explode("\r\n", $string);

        $uidvalidity = 0;
        $exists = 0;
        $recent = 0;
        $uidnext = 0;

        foreach ($lines as $line) {
            if (strpos($line, "UIDVALIDITY") !== false) {
                $uidvalidity = (int) filter_var($line, FILTER_SANITIZE_NUMBER_INT);
            } elseif (strpos($line, "EXISTS") !== false) {
                $exists = (int) filter_var($line, FILTER_SANITIZE_NUMBER_INT);
            } elseif (strpos($line, "RECENT") !== false) {
                $recent = (int) filter_var($line, FILTER_SANITIZE_NUMBER_INT);
            } elseif (strpos($line, "UIDNEXT") !== false) {
                $uidnext = (int) filter_var($line, FILTER_SANITIZE_NUMBER_INT);
            }
        }

        return new \Evt\Imap\Structures\Mailbox($this->mailbox, $uidvalidity, $exists, $recent, $uidnext);
    }
}
