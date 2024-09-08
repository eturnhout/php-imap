<?php

declare(strict_types=1);

namespace Evt\Imap\Parsers\Helpers;

use Evt\Imap\Structures\Envelope as EnvelopeStructure;

class Envelope
{
    /**
     * Parses a raw envelope returned by a imap server and converts it to a Envelope object
     * This follows the structure described in rfc3501#section-7.4.2
     */
    public static function parse($envelope): EnvelopeStructure
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
        $from = Addresses::parse($messyFrom);
        $sender = Addresses::parse($messySender);
        $replyTo = Addresses::parse($messyReplyTo);
        $to = Addresses::parse($messyTo);
        $cc = Addresses::parse($messyCc);
        $bcc = Addresses::parse($messyBcc);
        $inReplyTo = trim(trim($messyInReplyTo), "\"");
        $messageId = trim(trim($rawEnvelope), "\"");

        return new EnvelopeStructure($date, $subject, $from, $sender, $replyTo, $to, $cc, $bcc, $inReplyTo, $messageId);
    }
}
