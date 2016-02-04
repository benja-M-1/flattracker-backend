<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Visit;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class VisitController
 *
 * @Route("/api/v1/visits")
 */
class VisitController extends Controller
{
    /**
     * @Rest\Get("/{id}", requirements={"id"="\d+"}, defaults={"_format" = "json"})
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
}
