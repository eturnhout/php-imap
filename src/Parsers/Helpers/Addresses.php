<?php declare(strict_types=1);

namespace Evt\Imap\Parsers\Helpers;

use Evt\Imap\Structures\Addresses as AddressesStructure;

class Addresses
{
    /**
     * Parses envelope fields like cc where more addresses are possible
     *
     * @param string $addresses The raw address string from (( to ))
     *
     * @return Evt\Imap\Structures\Addresses
     */
    public static function parse(string $addresses) : AddressesStructure
    {
        $trimmedAddresses = trim(trim($addresses), "()");
        $addressStack = new AddressesStructure();

        if ($trimmedAddresses == "NIL") {
            return $addressStack;
        }

        if (strpos($trimmedAddresses, ")(") !== false) {
            $splitAddresses = explode(")(", trim(str_replace(array(
                "((",
                "))"
            ), "", $addresses)));

            foreach ($splitAddresses as $address) {
                $addressStack->push(Address::parse($address));
            }
        } else {
            $trimmedAddress = trim(str_replace(array(
                "((",
                "))"
            ), "", $addresses));
            $addressStack->push(Address::parse($trimmedAddress));
        }

        return $addressStack;
    }
}
