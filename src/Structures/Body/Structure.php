<?php

declare(strict_types=1);

namespace Evt\Imap\Structures\Body;

/**
 * More or less two stacks of body info objects
 * One with the message's content, the other with attachments
 */
final class Structure
{
    public function __construct(
        private InfoStack $messageInfoStack,
        private InfoStack $attachmentInfoStack
    ) {}

    /**
     * Get the stack with MessageInfo objects
     */
    public function getMessageInfoStack(): InfoStack
    {
        return $this->messageInfoStack;
    }

    /**
     * Get the stack containing AttachmentInfo objects
     */
    public function getAttachmentInfoStack(): InfoStack
    {
        return $this->attachmentInfoStack;
    }
}
