<?php

namespace AppBundle\Listener;


use AppBundle\Event\VisitEvent;
use AppBundle\Events;
use Embed\Embed;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Log\LoggerInterface;

class VisitUpdateListener implements EventSubscriberInterface
{
    /** @var LoggerInterface */
    private $logger;

    /**
     * VisitUpdateListener constructor
     * .
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger;
    }

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
            $info = Embed::create($url);
            array_merge($metadata, [
                'title' => $info->getTitle(),
                'description' => $info->getDescription(),
            ]);
        } catch (\Exception $e) {
            $this->logger->info($e->getMessage());
        }
    }
}
