<?php declare(strict_types=1);

namespace Evt\Imap\Parsers;

class Capability implements ParserInterface
{
    public function parse(?string $response): \Evt\Imap\Structures\Capability\AbstractCapability
    {
        if ( ! $response) {
            throw new \Exception("No login capabilities returned");
        }

        if (strpos($response, 'AUTH=XOAUTH2') !== false) {
            return new \Evt\Imap\Structures\Capability\XOauth2();
        } else {
            return new \Evt\Imap\Structures\Capability\Plain();
        }
    }
}
