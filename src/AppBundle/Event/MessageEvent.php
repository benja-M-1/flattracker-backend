<?php

namespace AppBundle\Event;

use AppBundle\Entity\Message;
use Symfony\Component\EventDispatcher\Event;


/**
 * Class MessageEvent
 */
class MessageEvent extends Event
{
    /** @var Message */
    private $message;

    /**
     * MessageEvent constructor.
     *
     * @param Message $message
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function getMessage()
    {
        return $this->message;
    }
}
