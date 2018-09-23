<?php
namespace Evt\Imap\Structure\Message;

use Evt\Imap\Structure\Envelope;
use Evt\Imap\Structure\Body\Structure as Bodystructure;

use Evt\Util\Validator as Validate;

/**
 * Evt\Imap\Structure\Message\Header
 *
 * This object contains basic information of a message's content, addresses and flags
 *
 * @author Eelke van Turnhout <eelketurnhout3@gmail.com>
 * @version 1.0
 */
class Header
{

    /**
     * The message's uid
     *
     * @var integer
     */
    protected $uid;

    /**
     * The message's envelope
     *
     * @var Evt\Imap\Structure\Envelope
     */
    protected $envelope;

    /**
     * The bodystructure of the message
     *
     * @var Evt\Imap\Structure\Body\Structure
     */
    protected $bodystructure;

    /**
     * The flags set for the message
     *
     * @var array
     */
    protected $flags;

    /**
     * Evt\Imap\Structure\Message\Header
     *
     * @param integer                           $uid            The message's uid
     * @param Evt\Imap\Structure\Envelope       $envelope       The message's envelope
     * @param Evt\Imap\Structure\Body\Structure $bodystructure  The message's bodystructure
     */
    public function __construct($uid, Envelope $envelope, Bodystructure $bodystructure, array $flags)
    {
        $this->setUid($uid);
        $this->setEnvelope($envelope);
        $this->setBodystructure($bodystructure);
        $this->setFlags($flags);
    }

    /**
     * Set the message's uid
     *
     * @param integer $uid The message's uid
     *
     * @throws \InvalidArgumentException
     */
    public function setUid($uid)
    {
        Validate::integer("uid", $uid, __METHOD__);
        $this->uid = $uid;
    }

    /**
     * Get the message's uid
     *
     * @return integer The message's uid
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * Set the message's envelope
     *
     * @param Evt\Imap\Structure\Envelope $envelope The message's envelope
     */
    public function setEnvelope(Envelope $envelope)
    {
        $this->envelope = $envelope;
    }

    /**
     * Get the message's envelope
     *
     * @return Evt\Imap\Structure\Envelope The message's envelope
     */
    public function getEnvelope()
    {
        return $this->envelope;
    }

    /**
     * Set the message's bodystructure
     *
     * @param Evt\Imap\Structure\Body\Structure $bodystructure The message's bodystructure
     */
    public function setBodystructure(Bodystructure $bodystructure)
    {
        $this->bodystructure = $bodystructure;
    }

    /**
     * Get the message's bodystructure
     *
     * @return Evt\Imap\Structure\Body\Structure The message's bodystructure
     */
    public function getBodystructure()
    {
        return $this->bodystructure;
    }

    /**
     * Set the flags for the message
     *
     * @param array $flags Array with the flags belongin to the message
     */
    public function setFlags(array $flags)
    {
        $this->flags = $flags;
    }

    /**
     * Get the flags of the message
     *
     * @return A array with the message's flags
     */
    public function getFlags()
    {
        return $this->flags;
    }
}
