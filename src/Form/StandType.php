<?php

namespace App\Form;

use App\Entity\Forum;
use App\Entity\Stand;
use App\Entity\Timeslot;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StandType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('picture')
            ->add('description')
            ->add('capacity')
            ->add('duration', null, [
                'widget' => 'single_text'
            ])
            ->add('OnWhichForum', EntityType::class, [
                'class' => Forum::class,
'choice_label' => 'id',
            ])
            ->add('timeSlots', EntityType::class, [
                'class' => Timeslot::class,
'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stand::class,
        ]);
    }
}
