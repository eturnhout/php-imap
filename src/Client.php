<?php declare(strict_types=1);

namespace Evt\Imap;

use Evt\Imap\Config;
use Evt\Imap\Cli;
use Evt\Imap\Helpers\Input\Utf7ImapInput;

/**
 * Client that communicates with a imap server and gives object responses
 *
 * @author Eelke van Turnhout <eelketurnhout3@gmail.com>
 */
class Client
{
    /**
     * @var \Evt\Imap\Config
     */
    private $config;

    /**
     * Object for imap server interactions
     *
     * @var \Evt\Imap\Cli
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
        $this->config = $config;
        $this->cli = new Cli($config->getConnectionConfig());
    }

    public function executeCommand(\Evt\Imap\Commands\CommandInterface $command): \Evt\Imap\Structures\StructureInterface
    {
        return $this->cli->execute($command);
    }

    public function listMailboxes(?string $referenceName = null, ?string $mailboxName = null): \Evt\Imap\Structures\Mailboxes
    {
        $referenceNameInput = $referenceName ? new Utf7ImapInput($referenceName) : null;
        $mailboxNameInput = $mailboxName ? new Utf7ImapInput($mailboxName) : null;

        return $this->executeCommand(new \Evt\Imap\Commands\ListMailboxes($referenceNameInput, $mailboxNameInput));
    }

    public function listSubscribedMailboxes(?string $referenceName = null, ?string $mailboxName = null): \Evt\Imap\Structures\Mailboxes
    {
        $referenceNameInput = $referenceName ? new Utf7ImapInput($referenceName) : null;
        $mailboxNameInput = $mailboxName ? new Utf7ImapInput($mailboxName) : null;

        return $this->executeCommand(new \Evt\Imap\Commands\ListSubscribedMailboxes($referenceNameInput, $mailboxNameInput));
    }

    public function selectMailbox(string $mailbox): \Evt\Imap\Structures\Mailbox
    {
        $mailboxInput = new Utf7ImapInput($mailbox);

        return $this->executeCommand(new \Evt\Imap\Commands\SelectMailbox($mailboxInput));
    }

    public function getMessageHeaders(int $fromUid, int $toUid = null) : \Evt\Imap\Structures\MessageHeaders
    {
        return $this->executeCommand(new \Evt\Imap\Commands\GetMessageHeaders($fromUid, $toUid));
    }

    public function login(): \Evt\Imap\Structures\Login
    {
        /** @var \Evt\Imap\Structures\CapabilityStack */
        $capabilityStack = $this->executeCommand(new \Evt\Imap\Commands\LoginCapability());
        $credentials = $this->config->getCredentialsConfig();

        if ($capabilityStack->has($credentials->getLoginType())) {
            return $this->executeCommand(new \Evt\Imap\Commands\Login($credentials));
        } else {
            throw new \Exception($credentials->getLoginType()->name() . " login no supported");
        }
    }

    public function logout(): \Evt\Imap\Structures\Logout
    {
        $response = $this->executeCommand(new \Evt\Imap\Commands\Logout());
        $this->cli->disconnect();

        return $response;
    }

    /**
     * Get a message with it's envelope and body parts
     *
     * @param integer $uid Uid of the message to fetch
     *
     * @return Evt\Imap\Structure\Message
     */
    /*public function getMessage($uid)
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
    }*/
}
