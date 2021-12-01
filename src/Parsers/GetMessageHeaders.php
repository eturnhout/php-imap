<?php declare(strict_types=1);

namespace Evt\Imap\Parsers;

use Evt\Imap\Parsers\Helpers\Envelope as EnvelopeParser;
use Evt\Imap\Parsers\Helpers\BodyStructure as BodyStructureParser;
use Evt\Imap\Parsers\Helpers\Flags as FlagsParser;
use Evt\Imap\Structures\Message\Header as MessageHeader;
use Evt\Imap\Structures\MessageHeaders;

class GetMessageHeaders implements ParserInterface
{
    public function parse(string $string) : \Evt\Imap\Structures\MessageHeaders
    {
        $lines = explode("\r\n", $string);

        $messageHeaders = new MessageHeaders();

        foreach ($lines as $line) {

            if ( ! $line) {
                continue;
            }

            $decodedLine = mb_decode_mimeheader($line);

            // First get the uid
            $matches = null;
            preg_match("~UID (?<uid>[0-9]+)~", $decodedLine, $matches);

            // @TODO Figure out how to handle messages that don't return a UID
            if ( ! isset($matches['uid'])) {
                continue;
            }

            $uid = (int) $matches['uid'];

            // Parse the envelope
            $envelopeStart = mb_strpos($decodedLine, "ENVELOPE");
            $envelopeEnd = mb_strpos($decodedLine, " BODYSTRUCTURE");

            // @TODO There seem to be messages without an ENVELOPE or BODYSTRUCTURE indicators, research how to handle these
            if ($envelopeStart === false || $envelopeEnd === false) {
                continue;
            }

            $rawEnvelope = mb_substr($decodedLine, $envelopeStart, $envelopeEnd - $envelopeStart);
            $decodedLine = str_replace($rawEnvelope, "", $decodedLine);
            $envelope = EnvelopeParser::parse($rawEnvelope);

            // Parse the bodystructure
            $bodystructureStart = strpos($decodedLine, "BODYSTRUCTURE");
            $rawBodystructure = substr($decodedLine, $bodystructureStart, strlen($decodedLine));

            if (strpos($rawBodystructure, "FLAGS") !== false) {
                $rawBodystructure = substr($decodedLine, $bodystructureStart, strpos($rawBodystructure, "FLAGS"));
            }

            $decodedLine = str_replace($rawBodystructure, "", $decodedLine);
            $bodystructure = BodyStructureParser::parse($rawBodystructure);

            // Parse the flags
            $flagsStart = strpos($decodedLine, "FLAGS");
            $rawFlags = substr($decodedLine, $flagsStart);
            $flags = FlagsParser::parse($rawFlags);

            $messageHeaders->push(new MessageHeader($uid, $envelope, $bodystructure, $flags));
        }

        return $messageHeaders;
    }
}
