<?php declare(strict_types=1);

namespace Evt\Imap;

use Evt\Imap\Config;
use Evt\Imap\Cli;
use Evt\Imap\Parser;
use Evt\Imap\Structure\Mailbox;
use Evt\Imap\Structure\Message\HeaderStack as MessageHeaders;
use Evt\Imap\Structure\Message\Header as MessageHeader;
use Evt\Imap\Structure\Envelope;
use Evt\Imap\Structure\Body\PartStack as BodyParts;
use Evt\Imap\Structure\Body\Part as BodyPart;
use Evt\Imap\Structure\Message;
use Evt\Util\Validator as Validate;

/**
 * Evt\Imap\Client
 *
 * Client that communicates with a imap server and gives object responses
 *
 * @author Eelke van Turnhout <eelketurnhout3@gmail.com>
 * @version 1.0
 */
class Client
{
    /**
     * Object for imap server interactions
     *
     * @var Evt\Imap\Cli
     */
    protected $cli;

    /**
     * For checking the logged in status
     *
     * @var boolean
     */
    protected $loggedIn;

    /**
     * For checking if a mailbox is selected or not
     *
     * @var boolean
     */
    protected $selectedMailbox;

    /**
     * Evt\Imap\Client
     *
     * @param Evt\Imap\Config $config The configurations for a imap server connection
     */
    public function __construct(Config $config)
    {
        $this->cli = new Cli($config);
    }

    public function executeCommand(\Evt\Imap\Commands\AbstractCommand $command)
    {
        $this->login();

        $response = $this->cli->execute($command);

        return $command->getParser()->parse($response);
    }

    /**
     * Select a mailbox to interact with
     *
     * @param string $mailbox Name of the mailbox to use
     *
     * @return Evt\Imap\Structure\Mailbox
     */
    public function useMailbox($mailbox)
    {
        $this->login();
        $response = $this->cli->select($mailbox);
        $lines = explode("\r\n", $response);

        $uidvalidity = 0;
        $exists = 0;
        $recent = 0;
        $uidnext = 0;

        foreach ($lines as $line) {
            if (strpos($line, "UIDVALIDITY") !== false) {
                $uidvalidity = (int) filter_var($line, FILTER_SANITIZE_NUMBER_INT);
            } elseif (strpos($line, "EXISTS") !== false) {
                $exists = (int) filter_var($line, FILTER_SANITIZE_NUMBER_INT);
            } elseif (strpos($line, "RECENT") !== false) {
                $recent = (int) filter_var($line, FILTER_SANITIZE_NUMBER_INT);
            } elseif (strpos($line, "UIDNEXT") !== false) {
                $uidnext = (int) filter_var($line, FILTER_SANITIZE_NUMBER_INT);
            }
        }

        return new Mailbox($mailbox, $uidvalidity, $exists, $recent, $uidnext);
    }

    /**
     * Get a range of message headers
     *
     * @param int $fromUid  The starting uid to fetch messages from
     * @param int $toUid    (optional) The last uid to fetch to
     *                      Set this to null if you only want the message with the $fromUid, else all message after the $fromUid are also fetched
     *
     * @return Evt\Imap\Structure\Message\HeaderStack The message headers with the uid, envelope and bodystructure
     *
     * @throws InvalidArgumentException
     */
    public function getMessageHeaders($fromUid, $toUid = "*")
    {
        Validate::integer("from-uid", $fromUid, __METHOD__);

        if (! is_null($toUid) && $toUid != "*" && ! is_int($toUid)) {
            throw new \InvalidArgumentException(__METHOD__ . '; "toUid" can only be an integer or the * symbol. ' . gettype($toUid) . ' given.');
        }

        $lastUid = (! is_null($toUid)) ? ":" . $toUid : "";
        $uids = $fromUid . $lastUid;
        $response = $this->cli->uidFetch($uids, "(ENVELOPE BODYSTRUCTURE FLAGS)");
        $lines = explode("\r\n", $response);

        $messageHeaders = new MessageHeaders();

        foreach ($lines as $line) {
            if (strlen($line) != 0) {
                $decodedLine = mb_decode_mimeheader($line);

                // First get the uid
                $matches = null;
                preg_match("~UID (?<uid>[0-9]+)~", $decodedLine, $matches);
                $uid = (int) $matches['uid'];

                // Parse the envelope
                $envelopeStart = strpos($line, "ENVELOPE");
                $envelopeEnd = strpos($line, " BODYSTRUCTURE");
                $rawEnvelope = substr($decodedLine, $envelopeStart, $envelopeEnd - $envelopeStart);
                $decodedLine = str_replace($rawEnvelope, "", $decodedLine);
                $envelope = Parser::parseEnvelope($rawEnvelope);

                // Parse the bodystructure
                $bodystructureStart = strpos($decodedLine, "BODYSTRUCTURE");
                $rawBodystructure = substr($decodedLine, $bodystructureStart, strlen($decodedLine));

                if (strpos($rawBodystructure, "FLAGS") !== false) {
                    $rawBodystructure = substr($decodedLine, $bodystructureStart, strpos($rawBodystructure, "FLAGS"));
                }

                $decodedLine = str_replace($rawBodystructure, "", $decodedLine);
                $bodystructure = Parser::parseBodystructure($rawBodystructure);

                // Parse the flags
                $flagsStart = strpos($decodedLine, "FLAGS");
                $rawFlags = substr($decodedLine, $flagsStart);
                $flags = Parser::parseFlags($rawFlags);

                $messageHeaders->push(new MessageHeader($uid, $envelope, $bodystructure, $flags));
            }
        }

        return $messageHeaders;
    }

    /**
     * Get a message with it's envelope and body parts
     *
     * @param integer $uid Uid of the message to fetch
     *
     * @return Evt\Imap\Structure\Message
     */
    public function getMessage($uid)
    {
        Validate::integer("uid", $uid, __METHOD__);
        $this->login();
        $messageHeaders = $this->getMessageHeaders($uid, null);
        $messageHeader = $messageHeaders->pop();
        $bodystructure = $messageHeader->getBodystructure();
        $messageStructures = $bodystructure->getMessageInfoStack();
        $attachmentStructures = $bodystructure->getAttachmentInfoStack();

        $bodyParts = new BodyParts();
        $finalMessagePart = 1;

        // First get the message contents
        while ($messageStructures->valid()) {
            $structure = $messageStructures->current();
            $position = $messageStructures->key() + 1;

            $response = $this->cli->uidFetch((string) $uid, "(BODY[" . $finalMessagePart . "." . $position . "])");

            if (is_null($response)) {
                $response = $this->cli->uidFetch((string) $uid, "(BODY[" . $position . "])");
            }

            if (! is_null($response)) {
                $message = Parser::parseContent($response);
                $bodyParts->push(new BodyPart($messageStructures->current(), $message));
            }

            $messageStructures->next();
        }

        // Now get the attachments
        while ($attachmentStructures->valid()) {
            $structure = $attachmentStructures->current();
            $position = $attachmentStructures->key() + 2;
            $response = $this->cli->uidFetch((string) $uid, "(BODY[" . $position . "])");

            if (is_null($response)) {
                $response = $this->cli->uidFetch((string) $uid, "(BODY[" . $position . "])");
            }

            if (! is_null($response)) {
                $attachment = Parser::parseContent($response);
                $bodyParts->push(new BodyPart($attachmentStructures->current(), $attachment));
            }

            $attachmentStructures->next();
        }

        return new Message($messageHeader->getEnvelope(), $bodyParts);
    }

    /**
     * Method that logs the user in if this is not the case already
     */
    protected function login()
    {
        if (! $this->loggedIn) {
            $this->cli->login();
            $this->loggedIn = true;
        }
    }
}
