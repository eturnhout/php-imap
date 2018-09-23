<?php
namespace Evt\Imap\Structure;

use Evt\Util\Validator as Validate;

/**
 * Evt\Imap\Structure\Mailbox
 *
 * An object that holds properties like the number of existing messages and the next estimated uid
 *
 * @author Eelke van Turnhout <eelketurnhout3@gmail.com>
 * @version 1.0
 */
class Mailbox
{

    /**
     * Name of the mailbox
     *
     * @var string
     */
    protected $name;

    /**
     * The UIDVALIDITY, this is used to check if any messages have been received or removed
     *
     * @var int
     */
    protected $uidvalidity;

    /**
     * The number of existing messages
     *
     * @var int
     */
    protected $exists;

    /**
     * Number of recent messages
     *
     * @var int
     */
    protected $recent;

    /**
     * The estimated next uid available
     *
     * @var int
     */
    protected $uidnext;

    /**
     * Evt\Imap\Structure\Mailbox
     *
     * @param string    $name           The name of the mailbox
     * @param int       $uidvalidity    The uidvalidity
     * @param int       $exists         The number of existing messages
     * @param int       $recent         The number of recent messages
     * @param int       $uidnext        The next available uid
     */
    public function __construct($name, $uidvalidity, $exists, $recent, $uidnext)
    {
        $this->setName($name);
        $this->setUidvalidity($uidvalidity);
        $this->setExists($exists);
        $this->setRecent($recent);
        $this->setUidnext($uidnext);
    }

    /**
     * Set the mailbox's name
     *
     * @param string The name of the mailbox
     *
     * @throws \InvalidArgumentException
     */
    public function setName($name)
    {
        Validate::nonEmptyString("name", $name, __METHOD__);
        $this->name = $name;
    }

    /**
     * Get the mailbox's name
     *
     * @return string The name of the mailbox
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the uidvalidity
     *
     * @param int $uidvalidity  The uidvalidity
     *                          Used to check if any messages have been added or removed
     *
     * @throws \InvalidArgumentException
     */
    public function setUidvalidity($uidvalidity)
    {
        Validate::integer("uidvalidity", $uidvalidity, __METHOD__);
        $this->uidvalidity = $uidvalidity;
    }

    /**
     * Get the uidvalidity
     *
     * @return int The uidvalidity of this mailbox
     */
    public function getUidvalidity()
    {
        return $this->uidvalidity;
    }

    /**
     * Set the number of existing messages
     *
     * @param int $exists The number of existing messages
     *
     * @throws \InvalidArgumentException
     */
    public function setExists($exists)
    {
        Validate::integer("exists", $exists, __METHOD__);
        $this->exists = $exists;
    }

    /**
     * Get the number of existing messages
     *
     * @return int The number of existing messages
     */
    public function getExists()
    {
        return $this->exists;
    }

    /**
     * Set the number of recent messages
     *
     * @param int $recent The number of recent messages
     *
     * @throws \InvalidArgumentException
     */
    public function setRecent($recent)
    {
        Validate::integer("recent", $recent, __METHOD__);
        $this->recent = $recent;
    }

    /**
     * Get the number of recent messages
     *
     * @return int The number of recent messages
     */
    public function getRecent()
    {
        return $this->recent;
    }

    /**
     * Set the uidnext value
     *
     * @param int $uidnext The estimated next uid
     *
     * @throws \InvalidArgumentException
     */
    public function setUidnext($uidnext)
    {
        Validate::integer("uidnext", $uidnext, __METHOD__);
        $this->uidnext = $uidnext;
    }
}
