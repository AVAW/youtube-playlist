<?php

declare(strict_types=1);

namespace App\Form\Slack\Command;

use App\Entity\Slack\Command;
use App\Model\Slack\GetOrGetOrGetOrCreateRequest;
use App\Validator\Token\Valid;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;

class CommandType extends AbstractType
{

    protected ParameterBagInterface $bag;

    public function __construct(ParameterBagInterface $bag)
    {
        $this->bag = $bag;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('token', TextType::class, [
                'constraints' => [
                    new NotNull(),
                    new Valid($this->bag->get('slack')['verification_token']),
                ],
            ])
            ->add('teamId', TextType::class, [
                'constraints' => [
                    new NotNull(),
                ],
            ])
            ->add('teamDomain', TextType::class, [
                'constraints' => [
                    new NotNull(),
                ],
            ])
            ->add('channelId', TextType::class, [
                'constraints' => [
                    new NotNull(),
                ],
            ])
            ->add('channelName', TextType::class, [
                'constraints' => [
                    new NotNull(),
                ],
            ])
            ->add('userId', TextType::class, [
                'constraints' => [
                    new NotNull(),
                ],
            ])
            ->add('userName', TextType::class, [
                'constraints' => [
                    new NotNull(),
                ],
            ])
            ->add('command', ChoiceType::class, [
                'choices' => Command::NAME_VALUES,
                'constraints' => [
                    new NotNull(),
                ],
            ])
            ->add('text', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => GetOrGetOrGetOrCreateRequest::class,
            'csrf_protection' => false,
        ]);
    }

}
