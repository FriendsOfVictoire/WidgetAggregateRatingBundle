<?php

namespace Victoire\Widget\AggregateRatingBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Victoire\Bundle\CoreBundle\Form\WidgetType;


/**
 * WidgetAggregateRating form type
 */
class WidgetAggregateRatingType extends WidgetType
{
    /**
     * define form fields
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('bestRating', null, array(
                    'label' => 'widget_aggregaterating.form.bestRating.label'
            ))            ->add('worstRating', null, array(
                    'label' => 'widget_aggregaterating.form.worstRating.label'
            ));
        parent::buildForm($builder, $options);

    }


    /**
     * bind form to WidgetAggregateRating entity
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults(array(
            'data_class'         => 'Victoire\Widget\AggregateRatingBundle\Entity\WidgetAggregateRating',
            'widget'             => 'AggregateRating',
            'translation_domain' => 'victoire'
        ));
    }

    /**
     * get form name
     *
     * @return string The form name
     */
    public function getName()
    {
        return 'victoire_widget_form_aggregaterating';
    }
}
