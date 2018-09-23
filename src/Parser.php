<?php
namespace Evt\Imap;

use Evt\Imap\Structure\Envelope;
use Evt\Imap\Structure\AddressStack as Addresses;
use Evt\Imap\Structure\Address;
use Evt\Imap\Structure\Body\Structure as Bodystructure;
use Evt\Imap\Structure\Body\InfoStack as BodyInfoStack;
use Evt\Imap\Structure\Body\Info as BodyInfo;
use Evt\Imap\Structure\Message\Info as MessageInfo;
use Evt\Imap\Structure\Attachment as AttachmentInfo;

/**
 * Evt\Imap\Parser
 *
 * My attempt to parse incoming responses from the Imap class
 *
 * @author Eelke van Turnhout <eelketurnhout3@gmail.com>
 * @version 1.0
 */
class Parser
{

    /**
     * Parses a raw envelope returned by a imap server and converts it to a Envelope object
     * This follows the structure described in rfc3501#section-7.4.2
     *
     * @param string $envelope The raw envelope string
     *
     * @return Evt\Imap\Structure\Envelope
     */
    public static function parseEnvelope($envelope)
    {
        $nil = "NIL";
        $rawEnvelope = trim(trim(trim(substr($envelope, strpos($envelope, "ENVELOPE") + strlen("ENVELOPE"), strlen($envelope))), "("), ")");

        // Extract the date and remove it from the envelope
        $dateStart = strpos($rawEnvelope, "\"");
        $dateEnd = strpos($rawEnvelope, "\" ") + strlen("\" ");
        $messyDate = substr($rawEnvelope, $dateStart, $dateEnd);
        $rawEnvelope = substr_replace($rawEnvelope, "", $dateStart, $dateEnd);

        // Extract and remove the subject
        if (strpos($rawEnvelope, $nil) === 0) {
            $messySubject = $nil;
            $rawEnvelope = trim(substr_replace($rawEnvelope, "", 0, strlen($nil)));
        } else {
            // $subjectStart = strpos($rawEnvelope, "\"");
            $subjectEnd = strpos($rawEnvelope, "\" ", 2) + strlen("\" ");
            $messySubject = substr($rawEnvelope, 0, $subjectEnd);
            $rawEnvelope = substr_replace($rawEnvelope, "", 0, $subjectEnd);
        }

        // Extract and remove the from address
        if (strpos($rawEnvelope, $nil) === 0) {
            $messyFrom = $nil;
            $rawEnvelope = trim(substr_replace($rawEnvelope, "", 0, strlen($nil)));
        } else {
            // $fromStart = strpos($rawEnvelope, "((");
            $fromEnd = strpos($rawEnvelope, ")) ") + strlen(")) ");
            $messyFrom = substr($rawEnvelope, 0, $fromEnd);
            $rawEnvelope = substr_replace($rawEnvelope, "", 0, $fromEnd);
        }

        // Extract and remove the sender address
        if (strpos($rawEnvelope, $nil) === 0) {
            $messySender = $nil;
            $rawEnvelope = trim(substr_replace($rawEnvelope, "", 0, strlen($nil)));
        } else {
            // $senderStart = strpos($rawEnvelope, "((");
            $senderEnd = strpos($rawEnvelope, ")) ") + strlen(")) ");
            $messySender = substr($rawEnvelope, 0, $senderEnd);
            $rawEnvelope = substr_replace($rawEnvelope, "", 0, $senderEnd);
        }

        // Extract and remove the reply-to address
        if (strpos($rawEnvelope, $nil) === 0) {
            $messyReplyTo = $nil;
            $rawEnvelope = trim(substr_replace($rawEnvelope, "", 0, strlen($nil)));
        } else {
            // $replyToStart = strpos($rawEnvelope, "((");
            $replyToEnd = strpos($rawEnvelope, ")) ") + strlen(")) ");
            $messyReplyTo = substr($rawEnvelope, 0, $replyToEnd);
            $rawEnvelope = substr_replace($rawEnvelope, "", 0, $replyToEnd);
        }

        // Extract and remove the to address
        if (strpos($rawEnvelope, $nil) === 0) {
            $messyTo = $nil;
            $rawEnvelope = trim(substr_replace($rawEnvelope, "", 0, strlen($nil)));
        } else {
            // $toStart = strpos($rawEnvelope, "((");
            $toEnd = strpos($rawEnvelope, ")) ") + strlen(")) ");
            $messyTo = substr($rawEnvelope, 0, $toEnd);
            $rawEnvelope = substr_replace($rawEnvelope, "", 0, $toEnd);
        }

        // Extract the cc address(es)
        if (strpos($rawEnvelope, $nil) === 0) {
            $messyCc = $nil;
            $rawEnvelope = trim(substr_replace($rawEnvelope, "", 0, strlen($nil)));
        } else {
            // $ccStart = strpos($rawEnvelope, "((");
            $ccEnd = strpos($rawEnvelope, ")) ") + strlen(")) ");
            $messyCc = substr($rawEnvelope, 0, $ccEnd);
            $rawEnvelope = substr_replace($rawEnvelope, "", 0, $ccEnd);
        }

        // Extract and remove the bcc address(es)
        if (strpos($rawEnvelope, $nil) === 0) {
            $messyBcc = $nil;
            $rawEnvelope = trim(substr_replace($rawEnvelope, "", 0, strlen($nil)));
        } else {
            // $bccStart = strpos($rawEnvelope, "((");
            $bccEnd = strpos($rawEnvelope, ")) ") + strlen(")) ");
            $messyBcc = substr($rawEnvelope, 0, $bccEnd);
        }

        // Extract and remove the in-reply-to field
        if (strpos($rawEnvelope, $nil) === 0) {
            $messyInReplyTo = $nil;
            $rawEnvelope = trim(substr_replace($rawEnvelope, "", 0, strlen($nil)));
        } else {
            // $inReplyToStart = strpos($rawEnvelope, "\"");
            $inReplyToEnd = strpos($rawEnvelope, "\" ") + strlen("\" ");
            $messyInReplyTo = substr($rawEnvelope, 0, $inReplyToEnd);
            $rawEnvelope = substr_replace($rawEnvelope, "", 0, $inReplyToEnd);
        }

        $date = trim(trim($messyDate), "\"");
        $subject = trim(trim($messySubject), "\"");
        $from = self::parseAddresses($messyFrom);
        $sender = self::parseAddresses($messySender);
        $replyTo = self::parseAddresses($messyReplyTo);
        $to = self::parseAddresses($messyTo);
        $cc = self::parseAddresses($messyCc);
        $bcc = self::parseAddresses($messyBcc);
        $inReplyTo = trim(trim($messyInReplyTo), "\"");
        $messageId = trim(trim($rawEnvelope), "\"");

        return new Envelope($date, $subject, $from, $sender, $replyTo, $to, $cc, $bcc, $inReplyTo, $messageId);
    }

    public static function parseBodystructure($bodystructure)
    {
        $bodystructure = str_replace("BODYSTRUCTURE (", "", $bodystructure);
        $nil = "NIL";

        $messageInfoStack = new BodyInfoStack();
        $attachmentInfoStack = new BodyInfoStack();

        if (strpos($bodystructure, ")(") !== false) {
            $parts = explode(")(", $bodystructure);
            foreach ($parts as $part) {
                $part = trim($part, "(");
                $bodyInfo = self::parseBodystructurePart($part);

                if ($bodyInfo instanceof MessageInfo) {
                    $messageInfoStack->push($bodyInfo);
                } elseif ($bodyInfo instanceof AttachmentInfo) {
                    $attachmentInfoStack->push($bodyInfo);
                }
            }
        } else {
            $bodyInfo = self::parseBodystructurePart($bodystructure);

            if ($bodyInfo instanceof MessageInfo) {
                $messageInfoStack->push($bodyInfo);
            } elseif ($bodyInfo instanceof AttachmentInfo) {
                $attachmentInfoStack->push($bodyInfo);
            }
        }

        return new Bodystructure($messageInfoStack, $attachmentInfoStack);
    }

    /**
     * Parses the flags part of the response
     *
     * @param string $flags String with the flags part of the response
     *
     * @return array A array with the flags
     */
    public static function parseFlags($flags)
    {
        $flagsStart = strpos($flags, "FLAGS (") + strlen("FLAGS (");
        $flagsEnd = strpos($flags, ")");
        $flags = str_replace("\\", "", substr($flags, $flagsStart, $flagsEnd - $flagsStart));

        if (strlen($flags) == 0) {
            return array();
        }

        return explode(" ", $flags);
    }

    /**
     * Parses envelope fields like cc where more addresses are possible
     *
     * @param string $addresses The raw address string from (( to ))
     *
     * @return Evt\Imap\Structure\Addresses
     */
    protected static function parseAddresses($addresses)
    {
        $trimmedAddresses = trim(trim($addresses), "()");
        $addressStack = new Addresses();

        if ($trimmedAddresses == "NIL") {
            return $addressStack;
        }

        if (strpos($trimmedAddresses, ")(") !== false) {
            $splitAddresses = explode(")(", trim(str_replace(array(
                "((",
                "))"
            ), "", $addresses)));

            foreach ($splitAddresses as $address) {
                $addressStack->push(self::parseAddress($address));
            }
        } else {
            $trimmedAddress = trim(str_replace(array(
                "((",
                "))"
            ), "", $addresses));
            $addressStack->push(self::parseAddress($trimmedAddress));
        }

        return $addressStack;
    }

    /**
     * Parses a raw address string without the surrounding parenthesis
     *
     * @param string $address Raw address string without the parenthesis
     *
     * @return Evt\Imap\Structure\Address
     */
    protected static function parseAddress($address)
    {
        $nil = "NIL";
        $startNeedle = "\"";
        $endNeedle = "\" ";

        if (strpos($address, $nil) === 0) {
            $name = "";
            $address = trim(substr_replace($address, "", 0, strlen($nil)));
        } else {
            // $start = strpos($address, $startNeedle);
            $end = strpos($address, $endNeedle, 2) + strlen($endNeedle);
            $messyName = substr($address, 0, $end);
            $address = str_replace($messyName, "", $address);
            $name = trim(trim($messyName), "\"");
        }

        if (strpos($address, $nil) === 0) {
            $domain = "";
            $address = trim(substr_replace($address, "", 0, strlen($nil)));
        } else {
            // $start = strpos($address, $startNeedle);
            $end = strpos($address, $endNeedle, 2) + strlen($endNeedle);
            $messyDomain = substr($address, 0, $end);
            $address = str_replace($messyDomain, "", $address);
            $domain = trim(trim($messyDomain), "\"");
        }

        if (strpos($address, $nil) === 0) {
            $mailbox = "";
            $address = trim(substr_replace($address, "", 0, strlen($nil)));
        } else {
            // $start = strpos($address, $startNeedle);
            $end = strpos($address, $endNeedle, 2) + strlen($endNeedle);
            $messyMailbox = substr($address, 0, $end);
            $address = str_replace($messyMailbox, "", $address);
            $mailbox = trim(trim($messyMailbox), "\"");
        }

        if (strpos($address, $nil) === 0) {
            $host = "";
            $address = trim(substr_replace($address, "", 0, strlen($nil)));
        } else {
            $messyHost = $address;
            $host = trim(trim($messyHost), "\"");
        }

        return new Address($name, $domain, $mailbox, $host);
    }

    /**
     * Parses a segment of the bodystructure list and converts it into one of the BodyInfo object
     * Either a MessageInfo or AttachmentInfo object
     *
     * @param Evt\Imap\Structure\BodyInfo $part Raw sechment of a bodystructure
     *
     * @return Evt\Mail\Structure\Imap\BodyInfo|null
     */
    protected static function parseBodystructurePart($part)
    {
        $nil = "NIL";

        // What kind of content does this part contain
        $contentStart = strpos($part, "\"");
        $contentEnd = strpos($part, "\" ") + strlen("\" ");
        $messyContent = substr($part, $contentStart, $contentEnd - $contentStart);
        $part = substr_replace($part, "", $contentStart, strlen($messyContent));

        // Extract the content type
        $typeStart = strpos($part, "\"");
        $typeEnd = strpos($part, "\" ") + strlen("\" ");
        $messyType = substr($part, $typeStart, $typeEnd - $typeStart);
        $part = substr_replace($part, "", $typeStart, strlen($messyType));

        // Extract the charset/filename
        if (strpos($part, $nil) === 0) {
            $part = trim(substr_replace($part, "", 0, strlen($nil)));
            $messyCharset = "";
        } else {
            $charsetStart = strpos($part, "(\"");
            $charsetEnd = strpos($part, "\") ") + strlen("\") ");
            $messyCharset = substr($part, $charsetStart, $charsetEnd - $charsetStart);
            $part = substr_replace($part, "", $charsetStart, strlen($messyCharset));
        }

        // The next two parts are not important, just remove them
        for ($i = 0; $i < 2; $i ++) {
            if (strpos($part, $nil) === 0) {
                $part = trim(substr_replace($part, "", 0, strlen($nil)));
            } else {
                $partEnd = strpos($part, "\" ") + strlen("\" ");
                $part = substr_replace($part, "", 0, $partEnd);
            }
        }

        // Extract the encoding type
        if (strpos($part, $nil) === 0) { // This shouldn't pass
            $part = trim(substr_replace($part, "", 0, strlen($nil)));
            $messyEncoding = "";
        } else {
            $encodingEnd = strpos($part, "\" ") + strlen("\" ");
            $messyEncoding = substr($part, 0, $encodingEnd);
            $part = substr_replace($part, "", 0, $encodingEnd);
        }

        // Get the number of octets
        if (strpos($part, $nil) === 0) { // This shouldn't pass
            $part = trim(substr_replace($part, "", 0, strlen($nil)));
            $messyOcteds = "";
        } else {
            $octedsEnd = strpos($part, " ") + strlen(" ");
            $messyOcteds = substr($part, 0, $octedsEnd);
            $part = substr_replace($part, "", 0, $octedsEnd);
        }

        // Get the number of lines
        if (strpos($part, $nil) === 0) { // This shouldn't pass
            $part = trim(substr_replace($part, "", 0, strlen($nil)));
            $messyLines = "";
        } else {
            $linesEnd = strpos($part, " ") + strlen(" ");
            $messyLines = substr($part, 0, $linesEnd);
            $part = substr_replace($part, "", 0, $linesEnd);
        }

        $charset = "";
        $name = "";

        if (strlen($messyCharset) > 0) {
            $propStart = strpos($messyCharset, " \"") + strlen(" \"");
            $propEnd = strpos($messyCharset, "\"", $propStart);

            if (stripos($messyCharset, "name") !== false) {
                $name = substr($messyCharset, $propStart, $propEnd - $propStart);
            } elseif (stripos($messyCharset, "charset") !== false) {
                $charset = substr($messyCharset, $propStart, $propEnd - $propStart);
            }
        }

        $content = trim(trim($messyContent), "\"");
        $type = trim(trim($messyType), "\"");
        $encoding = trim(trim($messyEncoding), "\"");
        $octets = (int) trim($messyOcteds);
        $lines = (int) trim($messyLines);

        if (strlen($charset) > 0) {
            return new MessageInfo($charset, $lines, $content, $type, $encoding, $octets);
        } elseif (strlen($name) > 0) {
            return new AttachmentInfo($name, $content, $type, $encoding, $octets);
        }

        return null;
    }

    public static function parseContent($content)
    {
        $start = strpos($content, "}") + 1;
        $length = strlen($content) - $start + 1;

        if ((strrpos($content, "UID") - $length > 0) && (strrpos($content, "UID") - $length < 5)) { // Sometimes the uid is at the end of the response. @TODO find a better way to remove this if possible.
            $cleanContent = substr($content, $start, $length);
            $lastUidPosition = strrpos($cleanContent, "UID");
            $cleanContent = trim(substr($cleanContent, 0, $lastUidPosition));
        } else {
            $cleanContent = trim(substr($content, $start, $length), ")");
        }

        return $cleanContent;
    }
}
