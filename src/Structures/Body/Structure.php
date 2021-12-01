<?php declare(strict_types=1);

namespace Evt\Imap\Structures\Body;

/**
 * Evt\Imap\Structure\Body\Structure
 *
 * More or less two stacks of body info objects
 * One with the message's content, the other with attachments
 */
class Structure
{
    /**
     * Stack with Message Info objects
     *
     * @var \Evt\Imap\Structures\Body\InfoStack
     */
    protected $messageInfoStack;

    /**
     * Stack with AttachmentInfo objects.
     *
     * @var \Evt\Imap\Structures\Body\InfoStack
     */
    protected $attachmentInfoStack;

    /**
     * @param \Evt\Imap\Structures\Body\InfoStack $messageInfoStack       A stack with MessageInfo objects
     * @param \Evt\Imap\Structures\Body\InfoStack $attachmentInfoStack    A stack with AttachmentInfo objects
     */
    public function __construct(InfoStack $messageInfoStack, InfoStack $attachmentInfoStack)
    {
        $this->setMessageInfoStack($messageInfoStack);
        $this->setAttachmentInfoStack($attachmentInfoStack);
    }

    /**
     * Set the stack with MessageInfo objects
     *
     * @param \Evt\Imap\Structures\Body\InfoStack $messageInfoStack
     */
    public function setMessageInfoStack(InfoStack $messageInfoStack)
    {
        $this->messageInfoStack = $messageInfoStack;
    }

    /**
     * Get the stack with MessageInfo objects
     *
     * @return \Evt\Imap\Structures\Body\InfoStack The stack with MessageInfo objects
     */
    public function getMessageInfoStack() : InfoStack
    {
        return $this->messageInfoStack;
    }

    /**
     * Set the stack with AttachmentInfo objects
     *
     * @param \Evt\Imap\Structures\Body\InfoStack $attachmentInfoStack A stack with AttachmentInfo objects
     */
    public function setAttachmentInfoStack(InfoStack $attachmentInfoStack)
    {
        $this->attachmentInfoStack = $attachmentInfoStack;
    }

    /**
     * Get the stack containing AttachmentInfo objects
     *
     * @return Evt\Imap\Structure\Body\InfoStack The stach containing AttachmentInfo objects
     */
    public function getAttachmentInfoStack() : InfoStack
    {
        return $this->attachmentInfoStack;
    }
}
