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
        $metadata = [];
        $metadata = $this->updateMetadata($visit->getUrl(), $metadata);

        $visit->setMetadata($metadata);
    }

    /**
     * @param $url
     * @param $metadata
     *
     * @return array
     */
    private function updateMetadata($url, $metadata)
    {
        $info = [];

        try {
            $opengraphData = Embed::create($url);
            $info = array_merge($metadata, [
                'title' => $opengraphData->getTitle(),
                'description' => $opengraphData->getDescription(),
            ]);

        } catch (\Exception $e) {
            $this->logger->info($e->getMessage());
        }

        return $info;
    }
}
