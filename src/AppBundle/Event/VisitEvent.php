<?php

namespace AppBundle\Event;

use AppBundle\Entity\Visit;
use Symfony\Component\EventDispatcher\Event;


/**
 * Class VisitEvent
 */
class VisitEvent extends Event
{
    /** @var Visit */
    private $visit;

    /**
     * VisitEvent constructor.
     *
     * @param Visit $visit
     */
    public function __construct(Visit $visit)
    {
        $this->visit = $visit;
    }

    public function getVisit()
    {
        return $this->visit;
    }
}
