<?php

declare(strict_types=1);

namespace Evt\Imap\Parsers\Helpers;

use Evt\Imap\Structures\Body\AbstractInfo;
use Evt\Imap\Structures\Attachment as AttachmentInfo;
use Evt\Imap\Structures\Message\Info as MessageInfo;

class BodyStructurePart
{
    /**
     * Parses a segment of the bodystructure list and converts it into one of the BodyInfo object
     * Either a MessageInfo or AttachmentInfo object
     */
    public static function parse(string $part): ?AbstractInfo
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
        for ($i = 0; $i < 2; $i++) {
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
}
