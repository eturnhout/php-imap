<?php declare(strict_types=1);

namespace Evt\Imap\Commands;

use Evt\Imap\Helpers\Input\InputInterface;
use Evt\Imap\Parsers\ParserInterface;

/**
 * Get a list of mailboxes and the hierarchy delimiter
 * Runs the LIST command described in rfc3501#section-6.3.8
 */
class ListMailboxes extends AbstractCommand implements CommandInterface
{
    /**
     * @var InputInterface
     */
    protected $referenceName;

    /**
     * @var InputInterface
     */
    protected $mailboxName;

    /**
     * @param InputInterface $referenceName (optional) Reference name
     * @param InputInterface $mailboxName   (optional) Mailbox name with possible wildcards
     */
    public function __construct(?InputInterface $referenceName, ?InputInterface $mailboxName)
    {
        $this->referenceName = $referenceName;
        $this->mailboxName = $mailboxName;
    }

    public function getCommand() : string
    {
        $referenceName = $this->referenceName ? $this->referenceName->getInput() : '';
        $mailboxName = $this->mailboxName ? $this->mailboxName->getInput() : '*';

        return 'LIST "' . $referenceName . '" "' . $mailboxName . '"';
    }

    public function getParser(): ParserInterface
    {
        return new \Evt\Imap\Parsers\ListMailboxes();
    }
}
