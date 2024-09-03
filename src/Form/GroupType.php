<?php

namespace App\Form;

use App\Entity\Group;
use App\Entity\Timeslot;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('owner', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'name',
            ])
            ->add('participatingTo', EntityType::class, [
                'class' => Timeslot::class,
                'choice_label' => 'title',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Group::class,
        ]);
    }
}
