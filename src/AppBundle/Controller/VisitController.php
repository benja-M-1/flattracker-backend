<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Message;
use AppBundle\Entity\User;
use AppBundle\Entity\Visit;
use AppBundle\Event\MessageEvent;
use AppBundle\Event\VisitEvent;
use AppBundle\Events;
use AppBundle\Form\Type\MessageType;
use AppBundle\Form\Type\VisitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;

/**
 * Class VisitController
 *
 * @Route("/api/v1/visits")
 */
class VisitController extends Controller
{
    /**
     * @Rest\Get("", defaults={"_format" = "json"})
     * @ApiDoc(
     *  resource=true,
     *  section="Visits",
     *  output={"class"="AppBundle\Entity\Visit"},
     *  description="Get all visits"
     * )
     */
    public function cgetVisitAction()
    {
        return $this->getDoctrine()->getRepository('AppBundle:Visit')->findBy(array(), array('updatedAt' => 'DESC'));
    }

    /**
     * @Rest\Get("/{id}", defaults={"_format" = "json"})
     * @ApiDoc(
     *  resource=true,
     *  section="Visits",
     *  output={"class"="AppBundle\Entity\Visit"},
     *  description="Get visit"
     * )
     */
    public function getVisitAction(Visit $visit)
    {
        return $visit;
    }

    /**
     * @Rest\Put("/{visitId}/affect/{userId}", defaults={"_format" = "json"})
     * @ParamConverter("visit", options={"mapping": {"visitId": "id"}})
     * @ParamConverter("tracker", options={"mapping": {"userId": "id"}})
     */
    public function assignTrackerVisitAction(Visit $visit, User $tracker)
    {
        $em = $this->getDoctrine()->getManager();
        $visit->setTracker($tracker);
        $em->flush();

        return $visit;
    }

    /**
     * @Rest\Post("", defaults={"_format" = "json"})
     * @ApiDoc(
     *  resource=true,
     *  section="Visits",
     *  output={"class"="AppBundle\Entity\Visit"},
     *  description="Create visit"
     * )
     */
    public function createVisitAction(Request $request)
    {
        $visit = new Visit();
        $form = $this->createForm(new VisitType(), $visit);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->get('event_dispatcher')->dispatch(Events::VISIT_UPDATED, new VisitEvent($visit));

            $em = $this->getDoctrine()->getManager();
            $em->persist($visit);
            $em->flush();
            $view = View::create($visit, Response::HTTP_CREATED);
        } else {
            $view = View::create($form, Response::HTTP_BAD_REQUEST);
        }

        $handler = $this->get('fos_rest.view_handler');

        return $handler->handle($view);
    }

    /**
     * @Rest\Post("/visits/{visitId}/messages", defaults={"_format" = "json"})
     * @ApiDoc(
     *  resource=true,
     *  section="Visits",
     *  output={"class"="AppBundle\Entity\Visit"},
     *  description="Add message"
     * )
     * @ParamConverter("visit", options={"mapping": {"visitId": "id"}})
     */
    public function postMessageAction(Request $request, Visit $visit)
    {
        $message = new Message();
        $form = $this->createForm(new MessageType(), $message);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $visit->addMessage($message);
            $this->get('event_dispatcher')->dispatch(Events::MESSAGE_SENT, new MessageEvent($message));

            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();
            $view = View::create($visit, Response::HTTP_CREATED);
        } else {
            $view = View::create($form, Response::HTTP_BAD_REQUEST);
        }

        $handler = $this->get('fos_rest.view_handler');

        return $handler->handle($view);
    }
}
