<?php declare(strict_types=1);

namespace Evt\Imap\Helpers\Input;

interface InputInterface
{
    public function getInput(): string;
}
