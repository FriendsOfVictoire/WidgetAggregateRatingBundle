<?php

namespace Victoire\Widget\AggregateRatingBundle\Listener;

use Doctrine\ORM\EntityManagerInterface;
use Victoire\Bundle\BusinessPageBundle\Entity\BusinessPage;
use Victoire\Bundle\BusinessPageBundle\Entity\VirtualBusinessPage;
use Victoire\Bundle\CoreBundle\Event\PageRenderEvent;

class AggregateRatingListener
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function onRenderPage(PageRenderEvent $event)
    {
        $currentView = $event->getCurrentView();
        if($currentView instanceof BusinessPage || $currentView instanceof VirtualBusinessPage)
        {
            $businessEntityId = $currentView->getBusinessEntityId();
            $entityId = $currentView->getBusinessEntity()->getId();
            $ratings = $this->entityManager->getRepository("VictoireWidgetAggregateRatingBundle:Rating")->findBy(
                array(
                    "businessEntityId" => $businessEntityId,
                    "entityId" => $entityId
                )
            );
            $currentView->ratings = $ratings;
        }
    }
}
