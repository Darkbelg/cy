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
            ->add('channel', TextType::class, array('label' => 'Channel Name', 'attr' => ['placeholder' => 'Channel Name', 'class' => 'p-4'] , 'label_attr'=> array('class'=>'font-bold rounded py-2 px-4')))
            ->add('period',  ChoiceType::class, [
                'choices'  => [
                    'Day' => 'day',
                    'Week' => 'week'
                ],
                'attr'=> ['class' => 'font-bold rounded py-2 px-4'],
                'label_attr' => ['class' => 'p-4']
            ])
            ->add('search',SubmitType::class, array('label' => 'Search' , 'attr'=> array('class'=>'bg-red hover:bg-red-dark text-white font-bold py-2 px-4 rounded')));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => \App\Entity\SearchNostalgic::class,
        ));
    }
}
