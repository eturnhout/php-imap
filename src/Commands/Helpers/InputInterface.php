<?php declare(strict_types=1);

namespace Evt\Imap\Commands\Helpers;

interface InputInterface
{
    public function getInput(): string;
}
