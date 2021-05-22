<?php

declare(strict_types=1);

namespace App\Form\Slack\Interactivity;

use App\Form\Slack\Action\SlackActionType;
use App\Form\Slack\Conversation\SlackConversationType;
use App\Form\Slack\Team\SlackTeamType;
use App\Form\Slack\User\SlackUserType;
use App\Model\Slack\Interactivity\InteractivityGetOrCreateRequest;
use App\Validator\Token\Valid;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class SlackInteractivitiesType extends AbstractType
{

    protected ParameterBagInterface $bag;

    public function __construct(ParameterBagInterface $bag)
    {
        $this->bag = $bag;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Valid('block_actions'),
                ],
            ])
            ->add('token', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Valid($this->bag->get('slack')['verification_token']),
                ],
            ])
            ->add('triggerId', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('enterprise')
            ->add('isEnterpriseInstall', CheckboxType::class, [
                'constraints' => [
                    new NotNull(),
                ],
            ])
            ->add('responseUrl', TextType::class, [
                'constraints' => [
                    new NotBlank(),
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
            ->add('actions', CollectionType::class, [
                'entry_type' => SlackActionType::class,
                'allow_add' => true,
                'constraints' => [
                    new NotBlank(),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => InteractivityGetOrCreateRequest::class,
            'csrf_protection' => false,
        ]);
    }

}
