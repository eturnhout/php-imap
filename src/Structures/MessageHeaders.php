<?php

namespace Evt\Imap\Structures;

class MessageHeaders implements StructureInterface
{
    protected $headers;

    public function __construct(array $headers)
    {
        $this->setHeaders($headers);
    }

    public function setHeaders(array $headers)
    {
        $this->headers = $headers;

        return $this;
    }

    public function getHeaders()
    {
        return $this->headers;
    }
}
