<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\{TextType, TextareaType, SubmitType, NumberType, IntegerType}; 


class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('code')
            ->add('description', TextareaType::class, ['required' => false])
            ->add('tax', NumberType::class, ['scale' => 2, 'attr' => ['step' => 0.01]])
            ->add('units')
            ->add('price', NumberType::class, ['scale' => 2, 'attr' => ['step' => 0.01]])
            ->add('maxDiscount', NumberType::class, ['required' => false])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
