<?php declare(strict_types=1);

namespace Evt\Imap\Structures;

abstract class AbstractRaw implements StructureInterface
{
    private $response;

    public function __construct(string $response)
    {
        $this->response = $response;
    }

    public function getResponse()
    {
        return $this->response;
    }
}
