<?php

declare(strict_types=1);

namespace App\Form\Slack\SlashCommands;

use App\Entity\Slack\SlackCommand;
use App\Form\Slack\Conversation\SlackConversationType;
use App\Form\Slack\Team\SlackTeamType;
use App\Form\Slack\User\SlackUserType;
use App\Model\Slack\SlashCommands\GetOrCreateRequest;
use App\Validator\Token\Valid;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class SlackSlashCommandsType extends AbstractType
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
                    new NotBlank(),
                    new Valid($this->bag->get('slack')['verification_token']),
                ],
            ])
            ->add('team', SlackTeamType::class, [
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('conversation', SlackConversationType::class, [
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('user', SlackUserType::class, [
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('command', ChoiceType::class, [
                'choices' => SlackCommand::NAME_VALUES,
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('text', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => GetOrCreateRequest::class,
            'csrf_protection' => false,
        ]);
    }

}
