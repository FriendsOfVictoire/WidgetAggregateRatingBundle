<?php

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
     * @Route("/submit/{businessEntityId}/{entityId}", name="Rating_submit")
     *
     * @return Response
     */
    public function submitAction(Request $request, $businessEntityId, $entityId)
    {
        $userIP = $request->getClientIp();
        $em = $this->getDoctrine()->getManager();
        $ratingRepo = $em->getRepository("Victoire\Widget\AggregateRatingBundle\Entity\Rating");
        $rating = $ratingRepo->findOneOrCreate(
            array(
                "ipAddress" => $userIP,
                "businessEntityId" => $businessEntityId,
                "entityId" => $entityId
            )
        );
        $ratingForm = $this->createForm(new RatingType(), $rating);
        $ratingForm->handleRequest($request);
        if($ratingForm->isValid())
        {
            $em->persist($rating);
            $em->flush();
        }
        $values = $ratingRepo->getRatingValues([
            "businessEntityId" => $businessEntityId,
            "entityId" => $entityId
        ]);
        return new JsonResponse(
            [
                'success' => true,
                'ratingRound' => $values['ratingRound'],
                'ratingNumber' => $values['ratingNumber'],
            ]
        );
    }

}