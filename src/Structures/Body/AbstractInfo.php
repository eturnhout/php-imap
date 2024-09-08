<?php

declare(strict_types=1);

namespace Evt\Imap\Structures\Body;

/**
 * An abstract class with base body info
 */
abstract class AbstractInfo
{
    public function __construct(
        private string $content,
        private string $type,
        private string $encoding,
        private int $octets
    ) {}

    /**
     * Get the content info
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Get the content type
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Get the encoding used
     */
    public function getEncoding(): string
    {
        return $this->encoding;
    }

    /**
     * Get the amount of octets
     */
    public function getOctets(): int
    {
        return $this->octets;
    }
}
