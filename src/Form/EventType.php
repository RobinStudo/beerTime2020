<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Nom de l\'événement',
                )
            ))
            ->add('description', null, array(
                'label' => 'Description',
                'attr' => array(
                    'rows' => 4,
                )
            ))
            ->add('picture', UrlType::class, array(
                'label' => 'Image',
                'help' => 'L\'URL de l\'image de votre événement',
            ))
            ->add('startAt', null, array(
                'label' => 'Début de l\'événement',
                'widget' => 'single_text',
            ))
            ->add('endAt', null, array(
                'label' => 'Fin de l\'événement',
                'widget' => 'single_text',
            ))
            ->add('price', null, array(
                'label' => 'Prix',
            ))
            ->add('capacity', null, array(
                'label' => 'Capacité',
            ))
            ->add('place', null, array(
                'label' => 'Lieu',
                'choice_label' => 'name',
            ))
            ->add('categories', null, array(
                'choice_label' => 'name',
                'expanded' => true,
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
