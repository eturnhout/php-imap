<?php declare(strict_types=1);

namespace Evt\Imap\Commands;

abstract class AbstractCommand
{
    protected $debug = false;
    abstract public function getCommand() : string;
    abstract public function getParser() : \Evt\Imap\Parsers\ParserInterface;

    public function debugEnabled()
    {
        return $this->debug;
    }

    public function setDebug(bool $debug) : self
    {
        $this->debug = $debug;

        return $this;
    }
}
