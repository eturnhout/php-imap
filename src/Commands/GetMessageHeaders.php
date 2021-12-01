<?php declare(strict_types=1);

namespace Evt\Imap\Commands;

use Evt\Imap\Parsers\ParserInterface;


/**
 * Get a range of message headers
 */
class GetMessageHeaders extends AbstractCommand implements CommandInterface
{
    protected $fromUid;
    protected $toUid;

    /**
     * @param int $fromUid  The starting uid to fetch messages from
     * @param int $toUid    (optional) The last uid to fetch to
     *                      Set this to null if you only want the message with the $fromUid, else all message after the $fromUid are also fetched
     */
    public function __construct(int $fromUid, int $toUid = null)
    {
        $this->setFromUid($fromUid)
            ->setToUid($toUid);
    }

    /**
     */
    public function getCommand() : string
    {
        $lastUid = $this->getToUid() ? ':' . $this->getToUid() : ':*';
        $sequenceSet = $this->getFromUid() . $lastUid;

        return 'UID FETCH ' . $sequenceSet . ' (ENVELOPE BODYSTRUCTURE FLAGS)';
    }

    public function getParser() : ParserInterface
    {
        return new \Evt\Imap\Parsers\GetMessageHeaders();
    }

    public function setFromUid(int $fromUid) : self
    {
        $this->fromUid = $fromUid;

        return $this;
    }

    public function getFromUid() : int
    {
        return $this->fromUid;
    }

    public function setToUid(int $toUid = null) : self
    {
        $this->toUid = $toUid;

        return $this;
    }

    public function getToUid() : ?int
    {
        return $this->toUid;
    }
}
