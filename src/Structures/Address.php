<?php

namespace Evt\Imap\Structures;

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
     * Evt\Imap\Structures\Address
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
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * Get the personal name belonging to the address
     *
     * @return string The personal name belonging to the address
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Set the address domain
     *
     * @param string $domain The address domain
     */
    public function setDomain(string $domain)
    {
        $this->domain = $domain;
    }

    /**
     * Get the address domain
     *
     * @return string The domain
     */
    public function getDomain() : string
    {
        return $this->domain;
    }

    /**
     * Set the mailbox for the address
     *
     * @param string $mailbox The mailbox
     */
    public function setMailbox(string $mailbox)
    {
        $this->mailbox = $mailbox;
    }

    /**
     * Get the mailbox
     *
     * @return string The mailbox
     */
    public function getMailbox() : string
    {
        return $this->mailbox;
    }

    /**
     * Set the address host
     *
     * @param string $host The host
     */
    public function setHost(string $host)
    {
        $this->host = $host;
    }

    /**
     * Get the address host
     *
     * @return string The address host
     */
    public function getHost() : string
    {
        return $this->host;
    }
}
