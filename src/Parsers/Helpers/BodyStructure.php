<?php

declare(strict_types=1);

namespace Evt\Imap\Parsers\Helpers;

use Evt\Imap\Structures\Body\Structure as BodyStructureStructure; // <- Inspired by Java :/
use Evt\Imap\Structures\Body\InfoStack as BodyInfoStack;
use Evt\Imap\Structures\Message\Info as MessageInfo;
use Evt\Imap\Structures\Attachment as AttachmentInfo;

class BodyStructure
{
    public static function parse(string $bodystructure): BodyStructureStructure
    {
        $bodystructure = str_replace("BODYSTRUCTURE (", "", $bodystructure);
        $nil = "NIL";

        $messageInfoStack = new BodyInfoStack();
        $attachmentInfoStack = new BodyInfoStack();

        if (strpos($bodystructure, ")(") !== false) {
            $parts = explode(")(", $bodystructure);
            foreach ($parts as $part) {
                $part = trim($part, "(");
                $bodyInfo = BodyStructurePart::parse($part);

                if ($bodyInfo instanceof MessageInfo) {
                    $messageInfoStack->push($bodyInfo);
                } elseif ($bodyInfo instanceof AttachmentInfo) {
                    $attachmentInfoStack->push($bodyInfo);
                }
            }
        } else {
            $bodyInfo = BodyStructurePart::parse($bodystructure);

            if ($bodyInfo instanceof MessageInfo) {
                $messageInfoStack->push($bodyInfo);
            } else if ($bodyInfo instanceof AttachmentInfo) {
                $attachmentInfoStack->push($bodyInfo);
            }
        }

        return new BodyStructureStructure($messageInfoStack, $attachmentInfoStack);
    }
}
