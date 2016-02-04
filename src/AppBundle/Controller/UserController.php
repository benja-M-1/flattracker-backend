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
     * @Rest\Put("", defaults={"_format" = "json"})
     * @ApiDoc(
     *  resource=true,
     *  section="Users",
     *  output={"class"="AppBundle\Entity\User"},
     *  description="Create user"
     * )
     */
    public function createUserAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(new UserType(), $user, ['method' => 'PUT']);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $view = View::create($user, Response::HTTP_CREATED);
        } else {
            $view = View::create($form, Response::HTTP_BAD_REQUEST);
        }

        $handler = $this->get('fos_rest.view_handler');

        return $handler->handle($view);
    }
}
