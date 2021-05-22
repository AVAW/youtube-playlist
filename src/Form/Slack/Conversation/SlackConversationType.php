<?php

declare(strict_types=1);

namespace App\Form\Slack\Conversation;

use App\Model\Slack\Conversation\ConversationGetOrCreateRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class SlackConversationType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('channelId', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('channelName', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ConversationGetOrCreateRequest::class,
            'csrf_protection' => false,
        ]);
    }

}
