<?php declare(strict_types=1);

namespace Evt\Imap\Commands;

use Evt\Imap\Parsers\ParserInterface;


/**
 * Get a list of mailboxes and the hierarchy delimiter
 * Runs the LIST command described in rfc3501#section-6.3.8
 *
 */
class ListMailboxes extends AbstractCommand implements CommandInterface
{
    protected $referenceName;
    protected $mailboxName;

    /**
     * @param string $referenceName (optional) Reference name
     * @param string $mailboxName   (optional) Mailbox name with possible wildcards
     */
    public function __construct(string $referenceName = '', string $mailboxName = '*')
    {
        $this->setReferenceName($referenceName)
            ->setMailboxName($mailboxName);
    }

    /**
     */
    public function getCommand() : string
    {
        return 'LIST "' . $this->getReferenceName() . '" "' . $this->getMailboxName() . '"';
    }

    public function getParser(): ParserInterface
    {
        return new \Evt\Imap\Parsers\ListMailboxes();
    }

    public function setReferenceName(string $referenceName) : self
    {
        $this->referenceName = $referenceName;

        return $this;
    }

    public function getReferenceName()
    {
        return $this->referenceName;
    }

    public function setMailboxName(string $mailboxName) : self
    {
        $this->mailboxName = $mailboxName;

        return $this;
    }

    public function getMailboxName()
    {
        return $this->mailboxName;
    }
}
