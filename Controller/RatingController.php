<?php
/**
 * Created by PhpStorm.
 * User: Charlie
 * Date: 27/11/15
 * Time: 16:15
 */

namespace Victoire\Widget\AggregateRatingBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Victoire\Widget\AggregateRatingBundle\Entity\Rating;
use Victoire\Widget\AggregateRatingBundle\Form\RatingType;

/**
 * Rating controller
 *
 * @Route("/rating")
 */

class RatingController extends Controller
{
    /**
     * Submit method.
     *
     *
     * @Route("/submit/{businessEntityId}/{entityId}", name="Rating_submit")
     *
     * @return Response
     */
    public function submitAction(Request $request, $businessEntityId, $entityId)
    {
        $userIP = $request->getClientIp();
        $em = $this->getDoctrine()->getManager();
        $rating = $em->getRepository("VictoireWidgetAggregateRatingBundle:Rating")->findOneBy(
            array(
                "ipAddress" => $userIP,
                "businessEntityId" => $businessEntityId,
                "entityId" => $entityId
            )
        );
        if(!$rating)
        {
            $rating = new Rating();
            $rating->setBusinessEntityId($businessEntityId);
            $rating->setEntityId($entityId);
            $rating->setIpAddress($userIP);
        }
        $ratingForm = $this->createForm(new RatingType(), $rating);
        $ratingForm->handleRequest($request);
        if($ratingForm->isValid())
        {
            $em->persist($rating);
            $em->flush();
            die('here');
        }
        return new JsonResponse(
            [
                'success' => true,
            ]
        );
    }

}