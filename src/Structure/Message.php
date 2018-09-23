<?php
namespace Evt\Imap\Structure;

use Evt\Imap\Structure\Envelope;
use Evt\Imap\Structure\Body\PartStack as BodyParts;

/**
 * Evt\Imap\Structure\Message
 *
 * @author Eelke van Turnhout <eelketurnhout3@gmail.com>
 * @version 1.0
 */
class Message
{

    protected $envelope;

    protected $bodyParts;

    /**
     * Evt\Imap\Structure\Message
     *
     * @param Evt\Imap\Structure\Envelope       The message's envolope
     * @param Evt\Imap\Structure\Body\PartStack The message's body parts
     */
    public function __construct(Envelope $envelope, BodyParts $bodyParts)
    {
        $this->setEnvelope($envelope);
        $this->setBodyParts($bodyParts);
    }

    public function setEnvelope(Envelope $envelope)
    {
        $this->envelope = $envelope;
    }

    public function getEnvelope()
    {
        return $this->envelope;
    }

    public function setBodyParts(BodyParts $bodyParts)
    {
        $this->bodyParts = $bodyParts;
    }

    public function getBodyParts()
    {
        return $this->bodyParts;
    }
}
