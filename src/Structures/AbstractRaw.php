<?php

declare(strict_types=1);

namespace Evt\Imap\Structures;

abstract class AbstractRaw implements StructureInterface
{
    public function __construct(
        private string $response
    ) {}

    public function getResponse()
    {
        return $this->response;
    }
}
