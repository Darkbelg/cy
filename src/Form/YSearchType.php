<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class YSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('channelId', TextType::class, array('label' => 'Name' , 'label_attr'=> array('class'=>'font-bold py-3 px-4 rounded')))
            ->add('search',SubmitType::class, array('label' => 'Search' , 'attr'=> array('class'=>'bg-red hover:bg-red-dark text-white font-bold py-2 px-4 rounded')));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => \App\Entity\SearchNostalgic::class,
        ));
    }
}
