<?php declare(strict_types=1);

namespace Evt\Imap\Commands;

use Evt\Imap\Parsers\ParserInterface;

/**
 * Select a mailbox to interact with
 */
class SelectMailbox extends AbstractCommand implements CommandInterface
{
    protected $mailbox;

    /**
     * @param string $mailbox Name of the mailbox to use
     */
    public function __construct(string $mailbox)
    {
        $this->setMailbox($mailbox);
    }

    /**
     */
    public function getCommand() : string
    {
        return 'SELECT "' . $this->getMailbox() . '"';
    }

    public function getParser() : ParserInterface
    {
        return new \Evt\Imap\Parsers\SelectMailbox($this->getMailbox());
    }

    public function setMailbox(string $mailbox) : self
    {
        $this->mailbox = $mailbox;

        return $this;
    }

    public function getMailbox()
    {
        return $this->mailbox;
    }
}
