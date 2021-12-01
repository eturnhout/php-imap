<?php declare(strict_types=1);

namespace Evt\Imap\Parsers;

class SelectMailbox implements ParserInterface
{
    protected $mailbox;

    public function __construct(string $mailbox)
    {
        $this->setMailbox($mailbox);
    }

    public function parse(string $string) : \Evt\Imap\Structures\StructureInterface
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

        return new \Evt\Imap\Structures\Mailbox($this->getMailbox(), $uidvalidity, $exists, $recent, $uidnext);
    }

    public function setMailbox(string $mailbox) : self
    {
        $this->mailbox = $mailbox;

        return $this;
    }

    public function getMailbox() : string
    {
        return $this->mailbox;
    }
}
