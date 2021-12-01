<?php
namespace Evt\Imap;

use Evt\Imap\Config;
use Evt\Imap\Client\AbstractClient;
use Evt\Imap\Commands\UntaggedCommandInterface;

/**
 * Evt\Imap\Cli
 *
 * Connect and interact with an imap server through a socket connection
 *
 * @author Eelke van Turnhout <eelketurnhout3@gmail.com>
 * @version 1.0
 */
class Cli extends AbstractClient
{
    /**
     * Every command to the imap server needs a unique tag
     * This is the prefix to that tag
     *
     * @var string
     */
    const TAG_PREFIX = 'AMWIJG';

    /**
     * Tag line to append to the tag prefix
     * This number should increase with every command send to the imap server
     *
     * @var int
     */
    protected $tagLine = 0;

    /**
     * The socket created while connecting.
     *
     * @var resource
     */
    protected $socket;

    /**
     * Used to handle errors.
     * An exception should be thrown when this is not null.
     *
     * @var string
     */
    protected $error;

    /**
     * Turns debug mode on to track the commands and responses.
     *
     * @var boolean
     */
    protected $debug;

    /**
     * Keeps track of the in/output when debug is set to true.
     *
     * @var string
     */
    protected $debugOutput;

    /**
     * Evt\Imap\Cli
     *
     * @param Evt\Imap\Config $config Configurations needed to connect and login to an imap server
     */
    public function __construct(Config $config)
    {
        parent::__construct($config);
        $this->debug = false;
    }

    /**
     * Connect to the server
     *
     * @throws \Exception
     */
    public function connect()
    {
        $connectionConfig = $this->getConfig()->getConnectionConfig();
        $address = $connectionConfig->getHost() . ':' . $connectionConfig->getPort();
        $fullAddress = $connectionConfig->usesSsl() ? 'ssl://' . $address : $address;

        $this->socket = stream_socket_client($fullAddress);

        if ( ! is_resource($this->socket)) {
            throw new \Exception(__METHOD__ . '; There was a problem creating the socket.');
        }

        if (is_null($this->read())) {
            throw new \Exception(__METHOD__ . '; Unable to read from the socket.');
        }
    }

    /**
     * Disconnect from the server
     *
     * @throws \Exception
     */
    public function disconnect()
    {
        if ( ! is_resource($this->socket)) {
            throw new \Exception(__METHOD__ . '; No need to disconnect, no connection was found.');
        }

        if ( ! fclose($this->socket)) {
            throw new \Exception(__METHOD__ . '; Unable to disconnect.');
        }
    }

    /**
     * Login with the username and key provided by the configurations
     */
    public function login()
    {
        if ( ! is_resource($this->socket)) {
            $this->connect();
        }

        $command = 'CAPABILITY';
        $this->sendCommand($command);
        $response = $this->read();
        $credentialsConfig = $this->getConfig()->getCredentialsConfig();

        if (strpos($response, 'AUTH=XOAUTH2') !== false && $credentialsConfig->usesOauth()) {
            $credentials = base64_encode("user=" . $credentialsConfig->getUsername() . "\1auth=Bearer " . $credentialsConfig->getKey() . "\1\1");
            $command = "AUTHENTICATE XOAUTH2 " . $credentials;

            $this->sendCommand($command);
            $response = $this->read();

            if (strrpos($response, '+') === 0) {
                $this->sendCommand('', true);
                $response = $this->read();
            }

            if (is_null($response)) {
                throw new \Exception(__METHOD__ . '; Unable to login.');
            }
        } else if ( ! $credentialsConfig->usesOauth()) {
            $credentials = $credentialsConfig->getUsername() . " " . $credentialsConfig->getKey();

            $this->sendCommand("LOGIN " . $credentials);
            $response = $this->read();

            if (is_null($response)) {
                throw new \Exception(__METHOD__ . "; Login failed.");
            }
        } else {
            throw new \Exception(__METHOD__ . '; The imap class can\'t find a supported authentication method on this server.');
        }
    }

    /**
     * Logout from the server
     * This may dosconnect and an exception will be thrown when trying to use the disconnect method
     *
     * @throws \Exception
     */
    public function logout()
    {
        if (! is_resource($this->socket)) {
            throw new \Exception(__METHOD__ . '; No connection was found.');
        }

        $this->sendCommand('LOGOUT');
        $response = $this->read();

        if (is_null($response)) {
            throw new \Exception(__METHOD__ . '; Logout failed.');
        }

        if (! fclose($this->socket)) {
            throw new \Exception(__METHOD__ . ': Failed to close socket connection.');
        }
    }

    /**
     * Get a list of subscribed mailboxes and the hierarchy delimiter
     * Runs the LSUB command described in rfc3501#section-6.3.9
     *
     * @param string $referenceName (optional) Reference name
     * @param string $mailboxName   (optional) Mailbox name with possible wildcards
     *
     * @return string The LSUB response from the server
     *
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    public function lsub($referenceName = '', $mailboxName = '*')
    {
        if (! is_string($referenceName)) {
            throw new \InvalidArgumentException(__METHOD__ . "; The reference name must be a non empty string.");
        }

        if (! is_string($mailboxName)) {
            throw new InvalidArgumentException(__METHOD__ . "; The mailbox name must be a string.");
        }

        $command = 'LSUB "' . $referenceName . '" "' . $mailboxName . '"';
        $this->sendCommand($command);

        $response = $this->read();

        if (is_null($response)) {
            throw new \Exception(__METHOD__ . '; Unable to list the mailboxes.');
        }

        $strippedResponse = $this->stripTag($response);

        return $strippedResponse;
    }

    /**
     * Print the in/output commands
     *
     * @return string The commands and responses
     */
    public function printDebugOutput()
    {
        echo $this->debugOutput;
    }

    /**
     * Send a command to the server
     *
     * @param string    $command    One of the commands described in rfc3501
     *                              NOTE: Do not pass a unique tag when extending this class, this is handled by the class itself
     * @param boolean   $untagged   Sometimes the server waits for input that doesn't require a tag e.g a simple newline
     *                              Set this to true if this is expected
     */
    protected function sendCommand($command, $untagged = false)
    {
        if ($untagged) {
            $fullCommand = $command . "\r\n";
        } else {
            $this->tagLine ++;
            $fullCommand = self::TAG_PREFIX . $this->tagLine . ' ' . $command . "\r\n";
        }

        if ($this->debug) {
            $this->debugOutput .= $fullCommand;
        }

        if (! fwrite($this->socket, $fullCommand)) {
            throw new Exception(__METHOD__ . '; Unable to write to socket.');
        }
    }

    public function execute(\Evt\Imap\Commands\AbstractCommand $command) : \Evt\Imap\Structures\StructureInterface
    {
        if ($command instanceof UntaggedCommandInterface) {
            $fullCommand = $command . "\r\n";
        } else {
            $this->tagLine ++;
            $fullCommand = self::TAG_PREFIX . $this->tagLine . ' ' . $command->getCommand() . "\r\n";
        }

        if ($command->debugEnabled()) {
            $this->debugOutput .= $fullCommand;
        }

        if ( ! fwrite($this->socket, $fullCommand)) {
            throw new \Exception(__METHOD__ . '; Unable to write to socket.');
        }

        $response = $this->read($command->debugEnabled());

        if ( ! $command instanceof UntaggedCommandInterface) {
            $response = $this->stripTag($response);
        }

        return $command->getParser()->parse($response);
    }

    /**
     * Read the server response
     * NOTE: Only use this after issuing a command
     *
     * @return string The response from the server.
     */
    protected function read(bool $debug = false)
    {
        $line = fread($this->socket, 2048);
        $this->error = null;
        $response = null;
        $tag = self::TAG_PREFIX . $this->tagLine;

        if (strpos($line, '* OK') === 0) {
            $response = $line;
        } elseif (strpos($line, $tag . " NO") !== false || strpos($line, $tag . " BAD") !== false || strpos($line, "* BAD") !== false || strpos($line, "* NO") !== false) {
            $this->error = trim($line);
        } elseif (! $line) {
            $this->error = 'Unable to read from the socket connection.';
        } else {
            $response .= $line;

            /*
             * If this passes based on the + sign at the start or end of the line, methods reading should check for this and act accordingly.
             */
            if (strpos($line, $tag) !== 0 && strpos($line, "+", strlen($line) - 1) === false && strpos($line, "+") !== 0) {
                while (strpos($line, "\r\n" . $tag) === false && strpos($line, $tag) !== 0) {
                    $line = fread($this->socket, 2048);
                    $response .= $line;
                }
            }
        }

        if ($debug && $this->error && ! $response) {
            $this->printDebugOutput();
            throw new \Exception(__METHOD__ . '; An error has occurred "' . $this->error . '"');
        } else if ($debug && $response) {
            $this->debugOutput .= $response;
        }

        return $response;
    }

    /**
     * Removes the tag from the response
     *
     * @param string $response The server's response to a command
     *
     * @return string The response without the tag
     *
     * @throws \InvalidArgumentException
     */
    protected function stripTag($response)
    {
        if (! is_string($response) || strlen($response) == 0) {
            throw new \InvalidArgumentException(__METHOD__ . "; The response must be a non empty string.");
        }

        if (strpos($response, self::TAG_PREFIX . $this->tagLine) == 0) {
            $needle = self::TAG_PREFIX . $this->tagLine;
        } else {
            $needle = "\r\n" . self::TAG_PREFIX . $this->tagLine;
        }

        $strippedResponse = substr($response, 0, strrpos($response, $needle));

        return $strippedResponse;
    }
}
