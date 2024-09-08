<?php

declare(strict_types=1);

namespace Evt\Imap\Parsers\Helpers;

use Evt\Imap\Structures\Address as AddressStructure;

class Address
{
    /**
     * Parses a raw address string without the surrounding parenthesis
     */
    public static function parse(string $address): AddressStructure
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

        return new AddressStructure($name, $domain, $mailbox, $host);
    }
}
