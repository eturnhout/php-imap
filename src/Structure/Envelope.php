<?php
namespace Evt\Imap\Structure;

use Evt\Imap\Structure\AddressStack as Addresses;

use Evt\Util\Validator as Validate;

/**
 * Evt\Imap\Structure\Envelope
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
     * @var Evt\Imap\Structure\Addresses
     */
    protected $from;

    /**
     * The message's sender
     *
     * @var Evt\Imap\Structure\Addresses
     */
    protected $sender;

    /**
     * The reply-to address(es) for the message.
     *
     * @var Evt\Imap\Structure\Addresses
     */
    protected $replyTo;

    /**
     * Address(es) to who the message was send
     *
     * @var Evt\Imap\Structure\Addresses
     */
    protected $to;

    /**
     * The cc address(es)
     *
     * @var Evt\Imap\Structure\Addresses
     */
    protected $cc;

    /**
     * Get the bcc address(es)
     *
     * @var Evt\Imap\Structure\Imap\Addresses
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
     * Evt\Imap\Structure\Envelope
     *
     * @param string $date                              A raw string containing the date
     * @param string $subject                           Subject of the message
     * @param Evt\Imap\Structure\AddressStack $from     The address(es) that describe who the message is from
     * @param Evt\Imap\Structure\AddressStack $sender   The message's sender
     * @param Evt\Imap\Structure\AddressStack $replyTo  The reply-to address(es)
     * @param Evt\Imap\Structure\AddressStack $to       The address(es) to who the message was send
     * @param Evt\Imap\Structure\AddressStack $cc       The cc address(es)
     * @param Evt\Imap\Structure\AddressStack $bcc      The bcc address(es)
     * @param string $inReplyTo                         The in-reply-to property provided by the imap server
     * @param string $messageId                         The message-id provided by the imap server
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
     *
     * @throws \InvalidArgumentException
     */
    public function setDate($date)
    {
        Validate::string("date", $date, __METHOD__);
        $this->date = $date;
    }

    /**
     * Get the message's date
     *
     * @return string A raw string containing the date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the message's subject
     *
     * @param string $subject Subject of the message
     *
     * @throws \InvalidArgumentException
     */
    public function setSubject($subject)
    {
        Validate::string("subject", $subject, __METHOD__);
        $this->subject = $subject;
    }

    /**
     * Get the message's subject
     *
     * @return string The subject
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set the address(es) from who the message is from
     *
     * @param Evt\Imap\Structure\AddressStack $from The address(es) from who the message is from
     */
    public function setFrom(Addresses $from)
    {
        $this->from = $from;
    }

    /**
     * Get the address(es) from who the message is from
     *
     * @return Evt\Imap\Structure\AddressStack
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Set the sender address(es) for the message
     *
     * @param Evt\Imap\Structure\AddressStack $sender
     */
    public function setSender($sender)
    {
        return $this->sender;
    }

    /**
     * Get the sender address(es) for the message
     *
     * @return Evt\Imap\Structure\AddressStack The sender address(es) for the message.
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Set the reply-to address(es)
     *
     * @param Evt\Imap\Structure\AddressStack $replyTo The reply-to addresses for the message
     */
    public function setReplyTo(Addresses $replyTo)
    {
        $this->replyTo = $replyTo;
    }

    /**
     * Get the reply-to address(es)
     *
     * @return Evt\Imap\Structure\AddressStack The reply-to address(es)
     */
    public function getReplyTo()
    {
        return $this->replyTo;
    }

    /**
     * Set the address(es) tho who the message was send to
     *
     * @param Evt\Imap\Structure\AddressStack $to The address(es) to who the message was send to
     */
    public function setTo(Addresses $to)
    {
        $this->to = $to;
    }

    /**
     * Get the address(es) to who the message was send to
     *
     * @return Evt\Imap\Structure\AddressStack The address(es) to who the message was send to
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * Set the cc address(es)
     *
     * @param Evt\Imap\Structure\AddressStack $cc The cc address(es)
     */
    public function setCc(Addresses $cc)
    {
        $this->cc = $cc;
    }

    /**
     * Get the cc address(es) from the message
     *
     * @return Evt\Imap\Structure\AddressStack The cc address(es)
     */
    public function getCc()
    {
        return $this->cc;
    }

    /**
     * Set the bcc address(es) for the message
     *
     * @param Evt\Imap\Structure\AddressStack $bcc The bcc address(es)
     */
    public function setBcc(Addresses $bcc)
    {
        $this->bcc = $bcc;
    }

    /**
     * Get the bcc address(es) for the message
     *
     * @return Evt\Imap\Structure\AddressStack The bcc address(es)
     */
    public function getBcc()
    {
        return $this->bcc;
    }

    /**
     * Set the in-reply-to property for the message
     *
     * @param string $inReplyTo The in-reply-to property supplied by the imap server
     *
     * @throws \InvalidArgumentException
     */
    public function setInReplyTo($inReplyTo)
    {
        Validate::string("in-reply-to", $inReplyTo, __METHOD__);
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
     *
     * @throws \InvalidArgumentException
     */
    public function setMessageId($messageId)
    {
        Validate::string("message-id", $messageId, __METHOD__);
        $this->messageId = $messageId;
    }

    /**
     * Get the message-id from the message
     *
     * @return string The message-id provided by the imap server
     */
    public function getMessageId()
    {
        return $this->messageId;
    }
}
