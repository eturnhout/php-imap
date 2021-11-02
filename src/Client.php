<?php declare(strict_types=1);

namespace Evt\Imap;

use Evt\Imap\Config;
use Evt\Imap\Cli;
use Evt\Imap\Parser;
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
     * Evt\Imap\Client
     *
     * @param Evt\Imap\Config $config The configurations for a imap server connection
     */
    public function __construct(Config $config)
    {
        $this->cli = new Cli($config);
    }

    public function executeCommand(\Evt\Imap\Commands\AbstractCommand $command) : \Evt\Imap\Structures\StructureInterface
    {
        $this->login();

        return $this->cli->execute($command);
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
