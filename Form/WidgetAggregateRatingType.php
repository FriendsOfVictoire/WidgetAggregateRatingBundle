<?php

namespace Victoire\Widget\AggregateRatingBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Victoire\Bundle\CoreBundle\Form\WidgetType;
use Victoire\Widget\AggregateRatingBundle\Entity\WidgetAggregateRating;


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
            ->add('options_size', ChoiceType::class, array(
                    'property_path' => "options[size]",
                    'choices' => $builder->getData()->getSizesAvailable(),
                    'label' => 'widget_aggregaterating.form.options.size.label'
            ))
            ->add('message', ChoiceType::class, array(
                    'choices' => $builder->getData()->getMessagesAvailable(),
                    'label' => 'widget_aggregaterating.form.message.label'
            ));
        parent::buildForm($builder, $options);

    }


    /**
     * bind form to WidgetAggregateRating entity
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'data_class'         => WidgetAggregateRating::class,
            'widget'             => 'AggregateRating',
            'translation_domain' => 'victoire'
        ));
    }
}
