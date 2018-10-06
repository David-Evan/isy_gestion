<?php

namespace App\Form;

use App\Entity\Customer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Form\AddressType;
use Symfony\Component\Form\Extension\Core\Type\{TextType, TextareaType, SubmitType, TelType, EmailType, ChoiceType}; 

class CustomerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('email', EmailType::class)
            ->add('phone', TelType::class, ['required' => false])
            ->add('type', ChoiceType::class, 
                        ['choices'  => [
                            'Particulier' => Customer::TYPE_INDIVIDUAL,
                            'Professionnel' => Customer::TYPE_PROFESSIONNAL,
                            'Service Public' => Customer::TYPE_PUBLIC,
                        ]
                    ])
            
            ->add('comment', TextareaType::class, ['required' => false])
            ->add('address', AddressType::class)
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Customer::class,
        ]);
    }
}
