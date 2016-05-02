<?php

namespace Victoire\Widget\AggregateRatingBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Victoire\Bundle\BusinessPageBundle\Entity\BusinessPage;
use Victoire\Bundle\BusinessPageBundle\Entity\BusinessTemplate;
use Victoire\Bundle\CoreBundle\Entity\View;
use Victoire\Bundle\PageBundle\Entity\Page;
use Victoire\Bundle\WidgetBundle\Entity\Widget;
use Victoire\Widget\AggregateRatingBundle\Entity\Rating;
use Victoire\Widget\AggregateRatingBundle\Entity\WidgetAggregateRating;
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
        $businessEntity = null;
        try{
            $businessEntity = $this->get('victoire_core.helper.business_entity_helper')->findById($businessEntityId);
        }catch (\Exception $e){}

        if($businessEntity)
        {
            $businessTemplates = $em->getRepository('VictoireBusinessPageBundle:BusinessTemplate')->findPagePatternByBusinessEntity($businessEntity);
            foreach( $businessTemplates as $businessTemplate)
            {
                /** @var BusinessPage $page */
                if($page = $em->getRepository(BusinessPage::class)->findPageByBusinessEntityAndPattern(
                    $businessTemplate, $entityId, $businessEntity
                ))
                {
                    $this->regenerateAssociatedWidgetsCache($page);
                }
            }

        }elseif($page = $em->getRepository(Page::class)->findOneBy(['id'=> $entityId]))
        {
            $this->regenerateAssociatedWidgetsCache($page);
        }

        return new JsonResponse(
            [
                'success' => true,
                'businessEntityId' => $businessEntityId,
                'entityId' => $entityId,
                'ratingRound' => $values['ratingRound'],
                'ratingNumber' => $values['ratingNumber'],
            ]
        );
    }
    private function regenerateAssociatedWidgetsCache(View $view)
    {
        $em =$this->getDoctrine()->getManager();
        $widgetCache = $this->get('victoire_widget.widget_cache');
        /** @var Widget $widget */
        $view->setReference($this->get('victoire_view_reference.repository')->findReferenceByView($view));
        $widgets = $em->getRepository(WidgetAggregateRating::class)->findBy(['view' => $view]);
        if(count($widgets) > 0)
        {
            foreach($widgets as $widget)
            {
                $widget->setCurrentView($view);
                $widgetCache->remove($widget);
            }
        }

    }

}