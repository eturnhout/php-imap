<?php
namespace Evt\Imap\Structure;

use Evt\Imap\Structure\Body\AbstractInfo as BodyInfo;

use Evt\Util\Validator as Validate;

/**
 * Evt\Imap\Structure\Attachment
 *
 * Some info about a attachment
 *
 * @author Eelke van Turnhout <eelketurnhout3@gmail.com>
 * @version 1.0
 */
class Attachment extends BodyInfo
{

    /**
     * Name of the attachment
     *
     * @var string
     */
    protected $name;

    /**
     * Evt\Imap\Structure\Attachment
     *
     * @param string    $name       Name of the attachment
     * @param string    $content    Info about the content e.g. text, application etc
     * @param string    $type       The content type
     * @param string    $encoding   The type of encoding used
     * @param integer   $octets     The amount of octets/bytes
     */
    public function __construct($name, $content, $type, $encoding, $octets)
    {
        parent::__construct($content, $type, $encoding, $octets);
        $this->setName($name);
    }

    /**
     * Set the name of the attachment
     *
     * @param string $name Name of the attachment
     *
     * @throws \InvalidArgumentException
     */
    public function setName($name)
    {
        Validate::nonEmptyString("name", $name, __METHOD__);
        $this->name = $name;
    }

    /**
     * Get the name for the attachment
     *
     * @return string The name
     */
    public function getName()
    {
        return $this->name;
    }
}
