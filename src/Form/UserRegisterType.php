<?php

namespace App\Form;

use App\Entity\Main\User;
use App\Repository\UserRepository;
use Faker\Provider\Text;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserRegisterType extends AbstractType
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,['help'=>'Введите имя'])
            ->add('password',PasswordType::class,['help'=>'Your Strong Password'])
            ->add('email',EmailType::class,['help'=>'Введите ваш email'])
            ->add('phone')
            ->add('title')
            ->add('invited_by',EntityType::class,['class'=>User::class,'choices'=> $this->userRepository->findAllWithDbId(),
                'choice_label'=>function(User $user){
                return sprintf('%s -- %s',$user->getName(),$user->getDbid());
            }

                ,'help'=>'Введите имя пользователя, который пригласил вас'])
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
