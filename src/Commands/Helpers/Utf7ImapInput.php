<?php declare(strict_types=1);

namespace Evt\Imap\Commands\Helpers;

final class Utf7ImapInput implements InputInterface
{
    private $input;

    public function __construct(string $input)
    {
        $this->input = \mb_convert_encoding($input, "UTF7-IMAP", "UTF-8");
    }

    public function getInput(): string
    {
        return $this->input;
    }
}
