<?php

declare(strict_types=1);

namespace Evt\Imap\Parsers\Uid;

use Evt\Imap\Parser;
use Evt\Imap\Parsers\ParserInterface;
use Exception;

final class Fetch implements ParserInterface
{
    public function parse(?string $response): \Evt\Imap\Structures\CapabilityStack
    {
        $sanitizedResponse = quoted_printable_decode(
            $this->sanitizeResponse(
                $response
            )
        );

        preg_match_all('/boundary="([0-9A-z]+)"/', $sanitizedResponse, $matches);

        $boundaries = $matches[1] ?? null;

        if ($boundaries === null || count($boundaries) === 0) {
            throw new Exception('No boundaries found');
        }

        $mainBoundary = $boundaries[0];

        if (count($boundaries) === 2) {
            print_r(explode('--' . $mainBoundary, $sanitizedResponse . '--'));

            /*print_r($text);
            echo "<br/><br/>";
            print_r($attachments);*/
        }

        $capabilityStack = new \Evt\Imap\Structures\CapabilityStack();

        return $capabilityStack;
    }

    private function sanitizeResponse(string $response): string
    {
        $start = mb_strpos($response, "}") + 1;
        $length = mb_strlen($response) - $start + 1;

        if ((mb_strrpos($response, "UID") - $length > 0) && (mb_strrpos($response, "UID") - $length < 5)) { // Sometimes the uid is at the end of the response. @TODO find a better way to remove this if possible.
            $cleanContent = mb_substr($response, $start, $length);
            $lastUidPosition = strrpos($cleanContent, "UID");
            $sanitizedResponse = trim(mb_substr($cleanContent, 0, $lastUidPosition));
        } else {
            $sanitizedResponse = trim(mb_substr($response, $start, $length), ")");
        }

        return $sanitizedResponse;
    }
}
