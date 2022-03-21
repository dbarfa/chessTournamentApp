<?php

namespace App\Form;

use App\Entity\Tournament;
use App\Enumeration\AgeCategoryEnum;
use App\Enumeration\SexEnum;
use App\Enumeration\TournTypeEnum;
use Doctrine\Tests_PHP81\Persistence\Reflection\TypedEnumClass;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddTournamentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('city')
            ->add('date')
            ->add('rated')
            ->add('eloMin')
            ->add('eloMax')
            ->add('ageCat',EnumType::class,[
                'class'=>AgeCategoryEnum::class
                ]
            )
            ->add('sex',EnumType::class,[
                'class' => SexEnum::class,

            ])
            ->add('type',EnumType::class,[
                'class'=>TournTypeEnum::class
            ])
            ->add('nrMin')
            ->add('nrMax')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tournament::class,
        ]);
    }
}
