<?php

declare(strict_types=1);

namespace App\Form\Slack\User;

use App\Model\Slack\User\UserGetOrCreateRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class SlackUserType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userId', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('userName', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserGetOrCreateRequest::class,
            'csrf_protection' => false,
        ]);
    }
}
