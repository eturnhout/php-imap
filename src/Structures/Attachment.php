<?php

declare(strict_types=1);

namespace Evt\Imap\Structures;

use Evt\Imap\Structures\Body\AbstractInfo as BodyInfo;

final class Attachment extends BodyInfo
{
    public function __construct(
        private string $name,
        string $content,
        string $type,
        string $encoding,
        int $octets
    ) {
        parent::__construct($content, $type, $encoding, $octets);
    }

    public function getName(): string
    {
        return $this->name;
    }
}
