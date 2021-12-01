<?php declare(strict_types=1);

namespace Evt\Imap\Commands;

abstract class AbstractCommand
{
    protected $debug = false;
    protected $untagged = false;
    abstract public function getCommand() : string;
    abstract public function getParser() : \Evt\Imap\Parsers\ParserInterface;

    public function isUntagged() : bool
    {
        return $this->untagged;
    }

    public function setUntagged(bool $untagged) : self
    {
        $this->untagged = $untagged;

        return $this;
    }

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
