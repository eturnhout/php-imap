<?php

declare(strict_types=1);

namespace Evt\Imap\Structures;

use Evt\Imap\Structures\Envelope;
use Evt\Imap\Structures\Body\PartStack as BodyParts;

final class Message
{
    public function __construct(
        private Envelope $envelope,
        private BodyParts $bodyParts,
    ) {}

    public function getEnvelope(): Envelope
    {
        return $this->envelope;
    }

    public function getBodyParts(): BodyParts
    {
        return $this->bodyParts;
    }
}
