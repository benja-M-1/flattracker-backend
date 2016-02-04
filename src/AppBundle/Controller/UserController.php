<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class VisitController
 *
 * @Route("/api/v1/users")
 */
class UserController extends Controller
{
    /**
     * @Rest\Get("/{facebookId}", requirements={"id"="\d+"}, defaults={"_format" = "json"})
     * @ApiDoc(
     *  resource=true,
     *  section="Users",
     *  output={"class"="AppBundle\Entity\User"},
     *  description="Get user by Facebook Id"
     * )
     */
    public function getVisitAction(User $user)
    {
        return $user;
    }
}
