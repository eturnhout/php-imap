<?php declare(strict_types=1);

namespace Evt\Imap\Structures;

use Evt\Imap\Structures\Envelope;
use Evt\Imap\Structures\Body\PartStack as BodyParts;

/**
 * Evt\Imap\Structures\Message
 *
 * @author Eelke van Turnhout <eelketurnhout3@gmail.com>
 * @version 1.0
 */
class Message
{
    protected $envelope;

    protected $bodyParts;

    /**
     * @param \Evt\Imap\Structures\Envelope       The message's envolope
     * @param \Evt\Imap\Structures\Body\PartStack The message's body parts
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

    public function getEnvelope() : Envelope
    {
        return $this->envelope;
    }

    public function setBodyParts(BodyParts $bodyParts)
    {
        $this->bodyParts = $bodyParts;
    }

    public function getBodyParts() : BodyParts
    {
        return $this->bodyParts;
    }
}
