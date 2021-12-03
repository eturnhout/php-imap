<?php declare(strict_types=1);

namespace Evt\Imap\Structures;

use Evt\Imap\Helpers\Utf7ImapToUtf8;

/**
 * An object that holds properties like the number of existing messages and the next estimated uid
 *
 * @author Eelke van Turnhout <eelketurnhout3@gmail.com>
 */
final class Mailbox implements StructureInterface
{
    /**
     * Name of the mailbox
     *
     * @var string
     */
    private $name;

    /**
     * The UIDVALIDITY, this is used to check if any messages have been received or removed
     *
     * @var int
     */
    private $uidvalidity;

    /**
     * The number of existing messages
     *
     * @var int
     */
    private $exists;

    /**
     * Number of recent messages
     *
     * @var int
     */
    private $recent;

    /**
     * The estimated next uid available
     *
     * @var int
     */
    private $uidnext;

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
        $this->uidvalidity = $uidvalidity;
        $this->exists = $exists;
        $this->recent = $recent;
        $this->uidnext = $uidnext;
    }

    /**
     * Set the mailbox's name
     *
     * @param string The name of the mailbox
     */
    private function setName(string $name): void
    {
        $this->name = Utf7ImapToUtf8::convert($name);
    }

    /**
     * Get the mailbox's name
     *
     * @return string The name of the mailbox
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the uidvalidity
     *
     * @return int The uidvalidity of this mailbox
     */
    public function getUidvalidity(): int
    {
        return $this->uidvalidity;
    }

    /**
     * Get the number of existing messages
     *
     * @return int The number of existing messages
     */
    public function getExists(): int
    {
        return $this->exists;
    }

    /**
     * Get the number of recent messages
     *
     * @return int The number of recent messages
     */
    public function getRecent(): int
    {
        return $this->recent;
    }

    public function getUidNext(): int
    {
        return $this->uidnext;
    }
}
