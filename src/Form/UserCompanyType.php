<?php

namespace App\Form;

use App\Entity\UserCompany;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Form\AddressType;
use Symfony\Component\Form\Extension\Core\Type\{SubmitType, EmailType}; 

class UserCompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('email', EmailType::class)
            ->add('address', AddressType::class)
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserCompany::class,
        ]);
    }
}
