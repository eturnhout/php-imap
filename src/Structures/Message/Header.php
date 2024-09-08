<?php

declare(strict_types=1);

namespace Evt\Imap\Structures\Message;

use Evt\Imap\Structures\Envelope;
use Evt\Imap\Structures\Body\Structure as Bodystructure;

class Header
{
    public function __construct(
        private int $uid,
        private Envelope $envelope,
        private Bodystructure $bodystructure,
        private array $flags
    ) {}

    /**
     * Get the message's uid
     */
    public function getUid(): int
    {
        return $this->uid;
    }

    /**
     * Get the message's envelope
     */
    public function getEnvelope(): Envelope
    {
        return $this->envelope;
    }

    /**
     * Get the message's bodystructure
     */
    public function getBodystructure(): Bodystructure
    {
        return $this->bodystructure;
    }

    /**
     * Get the flags of the message
     */
    public function getFlags(): array
    {
        return $this->flags;
    }
}
