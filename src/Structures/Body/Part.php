<?php declare(strict_types=1);

namespace Evt\Imap\Structures\Body;

use Evt\Imap\Structure\Body\AbstractInfo;

/**
 * Evt\Imap\Structures\Body\Part
 *
 * @author Eelke van Turnhout <eelketurnhout3@gmail.com>
 * @version 1.0
 */
class Part
{
    protected $info;

    protected $content;

    public function __construct(AbstractInfo $info, string $content)
    {
        $this->setInfo($info);
        $this->setContent($content);
    }

    public function setInfo(AbstractInfo $info)
    {
        $this->info = $info;
    }

    public function getInfo() : AbstractInfo
    {
        return $this->info;
    }

    public function setContent(string $content)
    {
        $this->content = $content;
    }

    public function getContent() : string
    {
        return $this->content;
    }
}
