<?php

declare(strict_types=1);

namespace Evt\Imap\Parsers;

class Capability implements ParserInterface
{
    public function parse(?string $response): \Evt\Imap\Structures\CapabilityStack
    {
        if (!$response) {
            throw new \Exception("No login capabilities returned");
        }

        $capabilityStack = new \Evt\Imap\Structures\CapabilityStack();

        if (strpos($response, 'AUTH=XOAUTH2') !== false) {
            $capabilityStack->push(new \Evt\Imap\Config\Login\XOauth2());
        }

        if (strpos($response, 'AUTH=PLAIN')) {
            $capabilityStack->push(new \Evt\Imap\Config\Login\Plain());
        }

        return $capabilityStack;
    }
}
