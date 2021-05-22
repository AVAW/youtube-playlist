<?php

declare(strict_types=1);

namespace App\Form\Slack\Team;

use App\Model\Slack\Team\TeamGetOrCreateRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class SlackTeamType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('teamId', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('teamDomain', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TeamGetOrCreateRequest::class,
            'csrf_protection' => false,
        ]);
    }

}
