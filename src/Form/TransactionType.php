<?php

namespace App\Form;

use App\Entity\Transaction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Negative;
use Symfony\Component\Validator\Validation;

class TransactionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {   
        if (true === $options['add']){
        $builder
            ->add('name', ChoiceType::class, [
                'choices' => [
                    'Bitcoin (BTC)' => 'BTC',
                    'Ethereum (ETH)' => 'ETH',
                    'Ripple (XRP)' => 'XRP'
                ],
                'multiple' => false,
                'required' => true,
                'label' => false,
                'placeholder' => 'Sélectionner une crypto'
            ])
            ->add('quantity', NumberType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Positive()
                ],
                'required' => true,
                'label' => false,
                'help' => 'Veuillez entrer une valeur positive',
                'attr' => [
                    'placeholder' => 'Quantité'
                ]
            ])
            ->add('purchase_price', NumberType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Positive()
                ],
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Prix d\'achat'
                ]
            ])
            ->add('submit', SubmitType::class)
        ;
     }
     else { 
         $builder
        ->add('name', ChoiceType::class, [
            'choices' => [
                'Bitcoin (BTC)' => 'BTC',
                'Ethereum (ETH)' => 'ETH',
                'Ripple (XRP)' => 'XRP'
            ],
            'multiple' => false,
            'required' => true,
            'label' => false,
            'placeholder' => 'Sélectionner une crypto'
        ])
            ->add('quantity', NumberType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Negative()
                ],
                'required' => true,
                'label' => false,
                'help' => 'Veuillez entrer une valeur négative',
                'attr' => [
                    'placeholder' => 'Quantité'
                ]
            ])
            ->add('submit', SubmitType::class)
        ;
    }
}

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'add' => true,
            'data_class' => Transaction::class,
        ]);
    }
}
