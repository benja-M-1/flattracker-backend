<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\Type\UserType;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class VisitController
 *
 * @Route("/api/v1/users")
 */
class UserController extends Controller
{
    /**
     * @Rest\Post("", defaults={"_format" = "json"})
     * @ApiDoc(
     *  resource=true,
     *  section="Users",
     *  output={"class"="AppBundle\Entity\User"},
     *  description="Create or update user"
     * )
     */
    public function createOrUpdateUserAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(new UserType(), $user);
        $em = $this->getDoctrine()->getManager();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($user);
            $em->flush();
            $view = View::create($user, Response::HTTP_CREATED);
        } else {
            $existingUser = $em->getRepository('AppBundle:User')->findOneBy(array('facebookId' => $user->getFacebookId()));
            if ($existingUser) {
                $view = View::create($existingUser, Response::HTTP_OK);
            } else {
                $view = View::create($form, Response::HTTP_BAD_REQUEST);
            }
        }

        $handler = $this->get('fos_rest.view_handler');

        return $handler->handle($view);
    }

    /**
     * @TODO: not really REST compliant...
     *
     * @Rest\Get("/{id}/visits-as-searcher", defaults={"_format" = "json"})
     */
    public function getUserVisitsAsSearcherAction(User $user)
    {
        return $user->getAsSearcherVisits();
    }

    /**
     * @TODO: not really REST compliant...
     *
     * @Rest\Get("/{id}/visits-as-tracker", defaults={"_format" = "json"})
     */
    public function getUserVisitsAsTrackerAction(User $user)
    {
        return $user->getAsSearcherVisits();
    }
}
