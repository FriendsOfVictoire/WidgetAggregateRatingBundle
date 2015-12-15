<?php
namespace Victoire\Widget\AggregateRatingBundle\Twig;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\OptionsResolver\Exception\InvalidArgumentException;
use Victoire\Bundle\BusinessPageBundle\Entity\BusinessPage;
use Victoire\Bundle\CoreBundle\Entity\View;
use Victoire\Bundle\PageBundle\Helper\PageHelper;
use Victoire\Widget\AggregateRatingBundle\Entity\WidgetAggregateRating;

class AggregateRatingExtension extends \Twig_Extension
{
    private $availableViews = [
      "microdata", "rdfa", "json", "stars"
    ];
    private $environment;
    private $em;
    private $pageHelper;

    public function __construct(\Twig_Environment $environment, EntityManagerInterface $em, PageHelper $pageHelper)
    {
        $this->environment = $environment;
        $this->em = $em;
        $this->pageHelper = $pageHelper;
    }

    public function getFunctions()
    {
        return array(
            'displayAggregateRating' => new \Twig_Function_Method($this, 'displayAggregateRating', array('is_safe' => array('html'))),
        );
    }

    public function displayAggregateRating($type = "microdata", $businessEntity, $entityId, $options = [])
    {
        $view = $this->pageHelper->findPageByParameters([
            'templateId' => $entityId,
            'entityId'   => $businessEntity->getId(),
        ]);
        if(!in_array($type, $this->availableViews))
        {
            throw new InvalidArgumentException( $type . ' is not an available view');
        }
        if($view instanceof BusinessPage)
        {
            $ratingValues = $this->em->getRepository('VictoireWidgetAggregateRatingBundle:Rating')->getRatingValues(array(
                "businessEntityId" => $view->getBusinessEntityId(),
                "entityId"         => $view->getBusinessEntity()->getId()
            ));
            if($type == "stars")
            {
                $widgetRating = new WidgetAggregateRating();
                $options = array_merge($widgetRating->getOptions(), $options);
            }
            return $this->environment->render('VictoireWidgetAggregateRatingBundle:Block:'.$type.'.html.twig',
                array(
                    'ratingNumber' => $ratingValues['ratingNumber'],
                    'ratingRound' => $ratingValues['ratingRound'],
                    'view' => $view,
                    'options' => $options
                )
            );
        }
    }

    public function getName()
    {
        return 'aggregate_rating_extension';
    }
}