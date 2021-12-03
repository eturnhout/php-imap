<?php declare(strict_types=1);

namespace Evt\Imap\Commands;

use Evt\Imap\Commands\Helpers\InputInterface;
use Evt\Imap\Parsers\ParserInterface;

/**
 * Select a mailbox to interact with
 */
class SelectMailbox extends AbstractCommand implements CommandInterface
{
    protected $mailbox;

    /**
     * @param InputInterface $mailbox Name of the mailbox to use
     */
    public function __construct(InputInterface $mailbox)
    {
        $this->mailbox = $mailbox;
    }

    public function getCommand() : string
    {
        return 'SELECT "' . $this->mailbox->getInput() . '"';
    }

    public function getParser() : ParserInterface
    {
        return new \Evt\Imap\Parsers\SelectMailbox($this->mailbox->getInput());
    }
}
