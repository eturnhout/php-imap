<?php

declare(strict_types=1);

namespace Evt\Imap\Structures;

final class Envelope
{
    public function __construct(
        private string $date,
        private string $subject,
        private Addresses $from,
        private Addresses $sender,
        private Addresses $replyTo,
        private Addresses $to,
        private Addresses $cc,
        private Addresses $bcc,
        private string $inReplyTo,
        private string $messageId,
    ) {}

    public function getDate(): string
    {
        return $this->date;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getFrom(): Addresses
    {
        return $this->from;
    }

    public function getSender(): Addresses
    {
        return $this->sender;
    }

    public function getReplyTo(): Addresses
    {
        return $this->replyTo;
    }

    public function getTo(): Addresses
    {
        return $this->to;
    }

    public function getCc(): Addresses
    {
        return $this->cc;
    }

    public function getBcc(): Addresses
    {
        return $this->bcc;
    }

    public function getInReplyTo()
    {
        return $this->inReplyTo;
    }

    public function getMessageId(): string
    {
        return $this->messageId;
    }
}
