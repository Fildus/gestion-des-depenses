<?php

namespace App\Form;

use App\Entity\Expenditure;
use App\Repository\SourceAccountRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExpenditureType extends AbstractType
{
    /**
     * @var SourceAccountRepository
     */
    private $sourceAccountRepository;

    public function __construct(SourceAccountRepository $sourceAccountRepository)
    {
        $this->sourceAccountRepository = $sourceAccountRepository;
    }

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
            ->add('sourceAccount', ChoiceType::class, [
                'label' => 'Compte source',
                'choices' => [$this->sourceAccountRepository->findAllByArray()],
                'required' => true
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
