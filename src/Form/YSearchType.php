<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class YSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('channel', TextType::class,
                [
                    'label' => 'Channel Name',
                    'attr' => [
                        'placeholder' => 'PewdiePie',
                        'class' => 'p-2'
                    ],
                    'label_attr' => [
                        'class' => 'pl-2'
                    ]
                ])
            ->add('period', ChoiceType::class, [
                'choices' => [
                    'Day' => 'day',
                    'Week' => 'week'
                ],
                'attr' => ['class' => 'p-2 bg-white pr-12'],
                'label_attr' => ['class' => 'pl-2']
            ])
            ->add('search', SubmitType::class, array('label' => 'Search', 'attr' => array('class' => 'bg-red-700 hover:bg-red-800 text-white font-bold py-2 px-4 rounded')));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => \App\Entity\SearchNostalgic::class,
        ));
    }
}
