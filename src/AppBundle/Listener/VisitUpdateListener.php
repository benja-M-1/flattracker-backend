<?php

namespace AppBundle\Listener;


use AppBundle\Event\VisitEvent;
use AppBundle\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use OpenGraph;

class VisitUpdateListener implements EventSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            Events::VISIT_UPDATED => 'updateVisitTitle',
        );
    }

    /**
     * @param VisitEvent $visitEvent
     */
    public function updateVisitTitle(VisitEvent $visitEvent)
    {
        $visit = $visitEvent->getVisit();
        $metadata = array();

        $this->updateMetadata($visit->getUrl(), $metadata);

        $visit->setMetadata($metadata);
    }

    /**
     * @param $url
     * @param $metadata
     */
    private function updateMetadata($url, &$metadata)
    {
        try {
            $graph = OpenGraph::fetch($url);
            array_merge($metadata, $graph);
        } catch (\Exception $e) {}
    }
}
