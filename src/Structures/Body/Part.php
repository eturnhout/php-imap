<?php

declare(strict_types=1);

namespace Evt\Imap\Structures\Body;

use Evt\Imap\Structures\Body\AbstractInfo;

class Part
{
    public function __construct(
        protected AbstractInfo $info,
        protected string $content
    ) {}

    public function getInfo(): AbstractInfo
    {
        return $this->info;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
