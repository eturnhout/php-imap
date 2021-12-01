<?php declare(strict_types=1);

namespace Evt\Imap\Structures;

/**
 * Evt\Imap\Structures\Envelope
 *
 * Generic envelope class with some info about the message sender and receiver
 * It follows the structure properties described in rfc3501#section-7.4.2
 *
 * @author Eelke van Turnhout <eelketurnhout3@gmail.com>
 * @version 1.0
 */
class Envelope
{
    /**
     * The message's date
     *
     * @var string
     */
    protected $date;

    /**
     * The message's subject
     *
     * @var string
     */
    protected $subject;

    /**
     * From who the message is from
     *
     * @var \Evt\Imap\Structures\Addresses
     */
    protected $from;

    /**
     * The message's sender
     *
     * @var \Evt\Imap\Structures\Addresses
     */
    protected $sender;

    /**
     * The reply-to address(es) for the message.
     *
     * @var \Evt\Imap\Structures\Addresses
     */
    protected $replyTo;

    /**
     * Address(es) to who the message was send
     *
     * @var \Evt\Imap\Structures\Addresses
     */
    protected $to;

    /**
     * The cc address(es)
     *
     * @var \Evt\Imap\Structures\Addresses
     */
    protected $cc;

    /**
     * Get the bcc address(es)
     *
     * @var \Evt\Imap\Structures\Addresses
     */
    protected $bcc;

    /**
     * The in-reply-to property suplied by the imap server
     *
     * @var string
     */
    protected $inReplyTo;

    /**
     * The message-id provided by the imap server
     *
     * @var string
     */
    protected $messageId;

    /**
     * @param string                            $date       A raw string containing the date
     * @param string                            $subject    Subject of the message
     * @param \Evt\Imap\Structures\Addresses    $from       The address(es) that describe who the message is from
     * @param \Evt\Imap\Structures\Addresses    $sender     The message's sender
     * @param \Evt\Imap\Structures\Addresses    $replyTo    The reply-to address(es)
     * @param \Evt\Imap\Structures\Addresses    $to         The address(es) to who the message was send
     * @param \Evt\Imap\Structures\Addresses    $cc         The cc address(es)
     * @param \Evt\Imap\Structures\Addresses    $bcc        The bcc address(es)
     * @param string                            $inReplyTo  The in-reply-to property provided by the imap server
     * @param string                            $messageId  The message-id provided by the imap server
     */
    public function __construct($date, $subject, Addresses $from, Addresses $sender, Addresses $replyTo, Addresses $to, Addresses $cc, Addresses $bcc, $inReplyTo, $messageId)
    {
        $this->setDate($date);
        $this->setSubject($subject);
        $this->setFrom($from);
        $this->setReplyTo($replyTo);
        $this->setTo($to);
        $this->setCc($cc);
        $this->setBcc($bcc);
        $this->setInReplyTo($inReplyTo);
        $this->setMessageId($messageId);
    }

    /**
     * Set the message's date
     *
     * @param string $date A raw string containing a date
     */
    public function setDate(string $date)
    {
        $this->date = $date;
    }

    /**
     * Get the message's date
     *
     * @return string A raw string containing the date
     */
    public function getDate() : string
    {
        return $this->date;
    }

    /**
     * Set the message's subject
     *
     * @param string $subject Subject of the message
     */
    public function setSubject(string $subject)
    {
        $this->subject = $subject;
    }

    /**
     * Get the message's subject
     *
     * @return string The subject
     */
    public function getSubject() : string
    {
        return $this->subject;
    }

    /**
     * Set the address(es) from who the message is from
     *
     * @param \Evt\Imap\Structures\Addresses $from The address(es) from who the message is from
     */
    public function setFrom(Addresses $from)
    {
        $this->from = $from;
    }

    /**
     * Get the address(es) from who the message is from
     *
     * @return \Evt\Imap\Structures\Addresses
     */
    public function getFrom() : Addresses
    {
        return $this->from;
    }

    /**
     * Set the sender address(es) for the message
     *
     * @param \Evt\Imap\Structures\Addresses $sender
     */
    public function setSender(Addresses $sender)
    {
        $this->sender = $sender;
    }

    /**
     * Get the sender address(es) for the message
     *
     * @return \Evt\Imap\Structures\Addresses The sender address(es) for the message.
     */
    public function getSender() : Addresses
    {
        return $this->sender;
    }

    /**
     * Set the reply-to address(es)
     *
     * @param \Evt\Imap\Structures\Addresses $replyTo The reply-to addresses for the message
     */
    public function setReplyTo(Addresses $replyTo)
    {
        $this->replyTo = $replyTo;
    }

    /**
     * Get the reply-to address(es)
     *
     * @return \Evt\Imap\Structures\Addresses The reply-to address(es)
     */
    public function getReplyTo() : Addresses
    {
        return $this->replyTo;
    }

    /**
     * Set the address(es) tho who the message was send to
     *
     * @param \Evt\Imap\Structures\Addresses $to The address(es) to who the message was send to
     */
    public function setTo(Addresses $to)
    {
        $this->to = $to;
    }

    /**
     * Get the address(es) to who the message was send to
     *
     * @return \Evt\Imap\Structures\Addresses The address(es) to who the message was send to
     */
    public function getTo() : Addresses
    {
        return $this->to;
    }

    /**
     * Set the cc address(es)
     *
     * @param \Evt\Imap\Structures\Addresses $cc The cc address(es)
     */
    public function setCc(Addresses $cc)
    {
        $this->cc = $cc;
    }

    /**
     * Get the cc address(es) from the message
     *
     * @return \Evt\Imap\Structures\Addresses The cc address(es)
     */
    public function getCc() : Addresses
    {
        return $this->cc;
    }

    /**
     * Set the bcc address(es) for the message
     *
     * @param \Evt\Imap\Structures\Addresses $bcc The bcc address(es)
     */
    public function setBcc(Addresses $bcc)
    {
        $this->bcc = $bcc;
    }

    /**
     * Get the bcc address(es) for the message
     *
     * @return \Evt\Imap\Structures\Addresses The bcc address(es)
     */
    public function getBcc() : Addresses
    {
        return $this->bcc;
    }

    /**
     * Set the in-reply-to property for the message
     *
     * @param string $inReplyTo The in-reply-to property supplied by the imap server
     */
    public function setInReplyTo(string $inReplyTo)
    {
        $this->inReplyTo = $inReplyTo;
    }

    /**
     * Get the in-reply-to property for the message
     *
     * @return string The in-reply-to property
     */
    public function getInReplyTo()
    {
        return $this->inReplyTo;
    }

    /**
     * Set the message-id.
     *
     * @param string $messageId The message-id provided by the imap server
     */
    public function setMessageId(string $messageId)
    {
        $this->messageId = $messageId;
    }

    /**
     * Get the message-id from the message
     *
     * @return string The message-id provided by the imap server
     */
    public function getMessageId() : string
    {
        return $this->messageId;
    }
}
