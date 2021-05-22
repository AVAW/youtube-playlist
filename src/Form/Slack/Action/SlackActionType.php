<?php

declare(strict_types=1);

namespace App\Form\Slack\Action;

use App\Model\Slack\Action\ActionCreateRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class SlackActionType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('actionId', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('value', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ActionCreateRequest::class,
            'csrf_protection' => false,
        ]);
    }

}
