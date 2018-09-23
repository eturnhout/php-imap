<?php
namespace Evt\Imap\Structure;

use Evt\Util\Validator as Validate;

/**
 * Evt\Imap\Structure\Address
 *
 * Mail address class for creating value objects
 *
 * @author Eelke van Turnhout <eelketurnhout3@gmail.com>
 * @version 1.0
 */
class Address
{

    /**
     * The personal name belonging to this address
     *
     * @var string
     */
    protected $name;

    /**
     * The domain for this address
     *
     * @var string
     */
    protected $domain;

    /**
     * The mailbox name
     *
     * @var string
     */
    protected $mailbox;

    /**
     * The address host
     *
     * @var string
     */
    protected $host;

    /**
     * Evt\Imap\Structure\Address
     *
     * @param string $name      Personal name belonging to the address
     * @param string $domain    The domain of this address
     * @param string $mailbox   The mailbox for the address
     * @param string $host      The address host
     */
    public function __construct($name, $domain, $mailbox, $host)
    {
        $this->setName($name);
        $this->setDomain($domain);
        $this->setMailbox($mailbox);
        $this->setHost($host);
    }

    /**
     * Set the personal name
     *
     * @param string $name The personal name for the address
     *
     * @throws \InvalidArgumentException When the name value isn't a string
     */
    public function setName($name)
    {
        Validate::string("name", $name, __METHOD__);
        $this->name = $name;
    }

    /**
     * Get the personal name belonging to the address
     *
     * @return string The personal name belonging to the address
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the address domain
     *
     * @param string $domain The address domain
     *
     * @throws \InvalidArgumentException When the value of domain isn't a string
     */
    public function setDomain($domain)
    {
        Validate::string("domain", $domain, __METHOD__);
        $this->domain = $domain;
    }

    /**
     * Get the address domain
     *
     * @return string The domain
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Set the mailbox for the address
     *
     * @param string $mailbox The mailbox
     *
     * @throws \InvalidArgumentException When the value of mailgox isn't a string
     */
    public function setMailbox($mailbox)
    {
        Validate::string("mailbox", $mailbox, __METHOD__);
        $this->mailbox = $mailbox;
    }

    /**
     * Get the mailbox
     *
     * @return string The mailbox
     */
    public function getMailbox()
    {
        return $this->mailbox;
    }

    /**
     * Set the address host
     *
     * @param string $host The host
     *
     * @throws \InvalidArgumentException When the value of host isn't a string
     */
    public function setHost($host)
    {
        Validate::string("host", $host, __METHOD__);
        $this->host = $host;
    }

    /**
     * Get the address host
     *
     * @return string The address host
     */
    public function getHost()
    {
        return $this->host;
    }
}
