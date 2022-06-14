<?php

namespace App\Form;

use App\Entity\Main\User;
use Faker\Provider\Text;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserRegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,['help'=>'Введите имя'])
            ->add('password',PasswordType::class,['help'=>'Your Strong Password'])
            ->add('email',EmailType::class,['help'=>'Введите ваш email'])
            ->add('phone')
            ->add('title')
            ->add('dateOfBirth',DateType::class,['years'=>range(1950,date('Y'))])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
