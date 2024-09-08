<?php

declare(strict_types=1);

namespace Evt\Imap\Structures\Message;

use Evt\Imap\Structures\Body\AbstractInfo;

final class Info extends AbstractInfo
{
    public function __construct(
        private string $charset,
        private int $lines,
        string $content,
        string $type,
        string $encoding,
        int $octets
    ) {
        parent::__construct($content, $type, $encoding, $octets);
    }

    /**
     * Get the charset of the message
     */
    public function getCharset(): string
    {
        return $this->charset;
    }

    /**
     * Get the number of lines in the message
     */
    public function getLines(): int
    {
        return $this->lines;
    }
}
