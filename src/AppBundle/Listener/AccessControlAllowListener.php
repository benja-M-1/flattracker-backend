<?php

namespace AppBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

/***
 * Use to allow cross domain requests.
 */
class AccessControlAllowListener
{
    /**
     * @TODO: Change Allow-Origin. Not really secure!
     *
     * @param FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $responseHeaders = $event->getResponse()->headers;
        $responseHeaders->set('Access-Control-Allow-Headers', 'Origin, Authorization, X-Requested-With, X-Cookie, X-Cookie-Response, Content-Type, Accept');
        $responseHeaders->set('Access-Control-Allow-Origin', $event->getRequest()->headers->get('origin', '*'));
        $responseHeaders->set('Access-Control-Allow-Methods', 'POST, GET, PUT, DELETE, OPTIONS');
        $responseHeaders->set('Access-Control-Allow-Credentials', 'true');
        $responseHeaders->set('Access-Control-Expose-Headers', 'Origin, Authorization, X-Requested-With, X-Cookie, X-Cookie-Response, Content-Type, Accept');
    }
}
