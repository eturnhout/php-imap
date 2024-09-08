<?php

declare(strict_types=1);

namespace Evt\Imap\Commands;

use Evt\Imap\Parsers\ParserInterface;

/**
 * Get a range of message headers
 * This class makes use of the UID command described here https://www.rfc-editor.org/rfc/rfc3501.html#section-6.4.8
 */
final class GetMessageHeaders extends AbstractCommand implements CommandInterface
{
    public function __construct(
        private int $fromUid,
        private ?int $toUid = null,
    ) {}

    public function getCommand(): string
    {
        $lastUid = $this->toUid ?? '*';
        $sequenceSet = $this->fromUid . ':' . $lastUid;

        return 'UID FETCH ' . $sequenceSet . ' (ENVELOPE BODYSTRUCTURE FLAGS)';
    }

    public function getParser(): ParserInterface
    {
        return new \Evt\Imap\Parsers\GetMessageHeaders();
    }
}
