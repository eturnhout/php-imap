<?php
namespace Evt\Imap\Structure\Body;

use Evt\Imap\Structure\Body\AbstractInfo;

use Evt\Util\Validator as Validate;

/**
 * Evt\Imap\Structure\Body\Part
 *
 * @author Eelke van Turnhout <eelketurnhout3@gmail.com>
 * @version 1.0
 */
class Part
{

    protected $info;

    protected $content;

    public function __construct(AbstractInfo $info, $content)
    {
        $this->setInfo($info);
        $this->setContent($content);
    }

    public function setInfo(AbstractInfo $info)
    {
        $this->info = $info;
    }

    public function getInfo()
    {
        return $this->info;
    }

    public function setContent($content)
    {
        Validate::string("content", $content, __METHOD__);
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }
}
