<?php

namespace App\Form;

use App\Entity\Expenditure;
use App\Entity\Uploads;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExpenditureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Intitulé'
            ])
            ->add('society', TextType::class, [
                'label' => 'Société'
            ])
            ->add('category', TextType::class, [
                'label' => 'Catégorie'
            ])
            ->add('type', TextType::class, [
                'label' => 'Type'
            ])
            ->add('sourceAccount', TextType::class, [
                'label' => 'Compte source'
            ])
            ->add('note', TextareaType::class, [
                'label' => 'Note'
            ])
            ->add('date', DateType::class, [
                'label' => 'Date',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd'
            ])
            ->add('amount', IntegerType::class, [
                'label' => 'Montant'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Expenditure::class,
        ]);
    }
}
