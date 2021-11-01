<?php declare(strict_types=1);

namespace Evt\Imap\Structures\Body;

/**
 * Evt\Imap\Structures\Body\AbstractInfo
 *
 * An abstract class with base body info
 *
 * @author Eelke van Turnhout <eelketurnhout3@gmcil.com>
 * @version 1.0
 */
abstract class AbstractInfo
{
    /**
     * Info about the content of the body
     *
     * @var string
     */
    protected $content;

    /**
     * Info about the type of content
     *
     * @var string
     */
    protected $type;

    /**
     * The type of encoding used on the content
     *
     * @var string
     */
    protected $encoding;

    /**
     * The amount of octets/bytes
     *
     * @var int
     */
    protected $octets;

    /**
     * Evt\Imap\Structure\Body\AbstractInfo
     *
     * @param string    $content    Info about the content e.g. text, application etc
     * @param string    $type       The content type
     * @param string    $encoding   The type of encoding used
     * @param int       $octets     The amount of octets/bytes
     */
    public function __construct(string $content, string $type, string $encoding, int $octets)
    {
        $this->setContent($content);
        $this->setType($type);
        $this->setEncoding($encoding);
        $this->setOctets($octets);
    }

    /**
     * Set the content info
     *
     * @param string $content E.g. text, application etc
     */
    public function setContent(string $content)
    {
        $this->content = $content;
    }

    /**
     * Get the content info
     *
     * @return string Content info
     */
    public function getContent() : string
    {
        return $this->content;
    }

    /**
     * Set the content type info
     *
     * @param string $type The type of content
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * Get the content type
     *
     * @return string The type of content
     */
    public function getType() : string
    {
        return $this->type;
    }

    /**
     * Set the type of encoding used
     *
     * @param string $encoding The type of encoding
     */
    public function setEncoding(string $encoding)
    {
        $this->encoding = $encoding;
    }

    /**
     * Get the encoding used
     *
     * @return string The encoding type used
     */
    public function getEncoding() : string
    {
        return $this->encoding;
    }

    /**
     * Set the amount of octets/bytes
     *
     * @param int $octets Octets amount
     */
    public function setOctets(int $octets)
    {
        $this->octets = $octets;
    }

    /**
     * Get the amount of octets
     *
     * @return int Octet amount
     */
    public function getOctets() : int
    {
        return $this->octets;
    }
}
