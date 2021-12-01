<?php declare(strict_types=1);

namespace Evt\Imap\Structures\Message;

use Evt\Imap\Structures\Body\AbstractInfo;

/**
 * Evt\Imap\Structures\Message\Info
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
     * @var int
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
    public function __construct(string $charset, int $lines, string $content, string $type, string $encoding, int $octets)
    {
        parent::__construct($content, $type, $encoding, $octets);
        $this->setCharset($charset);
        $this->setLines($lines);
    }

    /**
     * Set the charset used for the message
     *
     * @param string $charset The charset used
     */
    public function setCharset(string $charset)
    {
        $this->charset = $charset;
    }

    /**
     * Get the charset of the message
     *
     * @return string The charset used
     */
    public function getCharset() : string
    {
        return $this->charset;
    }

    /**
     * Set the number of lines in the message
     *
     * @param int $lines The number of lines in the message
     */
    public function setLines(int $lines)
    {
        $this->lines = $lines;
    }

    /**
     * Get the number of lines in the message
     *
     * @return int The number of lines in the message
     */
    public function getLines() : int
    {
        return $this->lines;
    }
}
