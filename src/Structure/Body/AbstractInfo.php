<?php
namespace Evt\Imap\Structure\Body;

use Evt\Util\Validator as Validate;

/**
 * Evt\Imap\Structure\Body\AbstractInfo
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
     * @var integer
     */
    protected $octets;

    /**
     * Evt\Imap\Structure\Body\AbstractInfo
     *
     * @param string    $content    Info about the content e.g. text, application etc
     * @param string    $type       The content type
     * @param string    $encoding   The type of encoding used
     * @param integer   $octets     The amount of octets/bytes
     */
    public function __construct($content, $type, $encoding, $octets)
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
     *
     * @throws \InvalidArgumentException
     */
    public function setContent($content)
    {
        Validate::string("content", $content, __METHOD__);
        $this->content = $content;
    }

    /**
     * Get the content info
     *
     * @return string Content info
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the content type info
     *
     * @param string $type The type of content
     *
     * @throws \InvalidArgumentException
     */
    public function setType($type)
    {
        Validate::string("type", $type, __METHOD__);
        $this->type = $type;
    }

    /**
     * Get the content type
     *
     * @return string The type of content
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the type of encoding used
     *
     * @param string $encoding The type of encoding
     */
    public function setEncoding($encoding)
    {
        Validate::string("encoding", $encoding, __METHOD__);
        $this->encoding = $encoding;
    }

    /**
     * Get the encoding used
     *
     * @return string The encoding type used
     */
    public function getEncoding()
    {
        return $this->encoding;
    }

    /**
     * Set the amount of octets/bytes
     *
     * @param integer $octets Octets amount
     *
     * @throws \InvalidArgumentException
     */
    public function setOctets($octets)
    {
        Validate::integer("octets", $octets, __METHOD__);
        $this->octets = $octets;
    }

    /**
     * Get the amount of octets
     *
     * @return string Octet amount
     */
    public function getOctets()
    {
        return $this->octets;
    }
}
