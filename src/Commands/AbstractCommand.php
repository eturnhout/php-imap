<?php declare(strict_types=1);

namespace Evt\Imap\Commands;

abstract class AbstractCommand
{
    protected $debug = false;

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
