<?php

namespace Victoire\Widget\AggregateRatingBundle\Resolver;


use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Victoire\Bundle\CoreBundle\Helper\CurrentViewHelper;
use Victoire\Bundle\WidgetBundle\Model\Widget;
use Victoire\Bundle\WidgetBundle\Resolver\BaseWidgetContentResolver;
use Victoire\Widget\AggregateRatingBundle\Entity\Rating;
use Victoire\Widget\AggregateRatingBundle\Form\RatingType;

/**
 * CRUD operations on WidgetAggregateRating Widget
 *
 * The widget view has two parameters: widget and content
 *
 * widget: The widget to display, use the widget as you wish to render the view
 * content: This variable is computed in this WidgetManager, you can set whatever you want in it and display it in the show view
 *
 * The content variable depends of the mode: static/businessEntity/entity/query
 *
 * The content is given depending of the mode by the methods:
 *  getWidgetStaticContent
 *  getWidgetBusinessEntityContent
 *  getWidgetEntityContent
 *  getWidgetQueryContent
 *
 * So, you can use the widget or the content in the show.html.twig view.
 * If you want to do some computation, use the content and do it the 4 previous methods.
 *
 * If you just want to use the widget and not the content, remove the method that throws the exceptions.
 *
 * By default, the methods throws Exception to notice the developer that he should implements it owns logic for the widget
 */
class WidgetAggregateRatingContentResolver extends BaseWidgetContentResolver
{
    private $request;
    private $currentViewHelper;
    private $formFactory;

    public function __construct(CurrentViewHelper $currentViewHelper, FormFactoryInterface $formFactory)
    {
        $this->currentViewHelper = $currentViewHelper;
        $this->formFactory = $formFactory;
    }
    /**
     * Get the static content of the widget
     *
     * @param Widget $widget
     * @return string The static content
     */
    public function getWidgetStaticContent(Widget $widget)
    {
        $parameters = parent::getWidgetStaticContent($widget);
        $currentView = $this->currentViewHelper->getCurrentView();
        $rating = $this->entityManager->getRepository("VictoireWidgetAggregateRatingBundle:Rating")->findOneOrCreate(
            array(
                "ipAddress" => $this->request->getClientIp(),
                "businessEntityId" => $currentView->getBusinessEntityId(),
                "entityId" => $currentView->getBusinessEntity()->getId()
            )
        );
        $ratingForm = $this->formFactory->create(new RatingType(), $rating);
        $parameters['ratingForm'] = $ratingForm->createView();
        $parameters['ratings'] = $this->entityManager->getRepository("VictoireWidgetAggregateRatingBundle:Rating")->findBy(
        array(
            "businessEntityId" => $currentView->getBusinessEntityId(),
            "entityId" => $currentView->getBusinessEntity()->getId()
            )
        );
        return $parameters;
    }

    /**
     * Get the business entity content
     * @param Widget $widget
     * @return string
     */
    public function getWidgetBusinessEntityContent(Widget $widget)
    {
        return parent::getWidgetBusinessEntityContent($widget);
    }

    /**
     * Get the content of the widget by the entity linked to it
     *
     * @param Widget $widget
     *
     * @return string
     */
    public function getWidgetEntityContent(Widget $widget)
    {
        return parent::getWidgetEntityContent($widget);
    }

    /**
     * Get the content of the widget for the query mode
     *
     * @param Widget $widget
     * @throws \Exception
     */
    public function getWidgetQueryContent(Widget $widget)
    {
        return parent::getWidgetQueryContent($widget);
    }

    public function setReQuest(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
    }
}
