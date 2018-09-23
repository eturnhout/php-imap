<?php
namespace Evt\Imap\Structure\Message;

use Evt\Imap\Structure\Body\AbstractInfo;

use Evt\Util\Validator as Validate;

/**
 * Evt\Imap\Structure\Message\Info
 *
 * Basic message info
 *
 * @author Eelke van Turnhout <eelketurnhout3@gmail.com>
 * @version 1.0
 */
class Info extends AbstractInfo
{

    /**
     * The charset of the message
     *
     * @var string
     */
    protected $charset;

    /**
     * The number of lines in the message
     *
     * @var integer
     */
    protected $lines;

    /**
     * Evt\Imap\Structure\Message\Info
     *
     * @param string    $content    Info about the content e.g. text, application etc
     * @param string    $type       The content type
     * @param string    $encoding   The type of encoding used
     * @param integer   $octets     The amount of octets/bytes
     */
    public function __construct($charset, $lines, $content, $type, $encoding, $octets)
    {
        parent::__construct($content, $type, $encoding, $octets);
        $this->setCharset($charset);
        $this->setLines($lines);
    }

    /**
     * Set the charset used for the message
     *
     * @param string $charset The charset used
     *
     * @throws \InvalidArgumentException
     */
    public function setCharset($charset)
    {
        Validate::nonEmptyString("charset", $charset, __METHOD__);
        $this->charset = $charset;
    }

    /**
     * Get the charset of the message
     *
     * @return string The charset used
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * Set the number of lines in the message
     *
     * @param integer $lines The number of lines in the message
     *
     * @throws \InvalidArgumentException
     */
    public function setLines($lines)
    {
        Validate::integer("lines", $lines, __METHOD__);
        $this->lines = $lines;
    }

    /**
     * Get the number of lines in the message
     *
     * @return string The number of lines in the message
     */
    public function getLines()
    {
        return $this->lines;
    }
}
