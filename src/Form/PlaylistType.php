<?php

declare(strict_types=1);

namespace App\Form;

use App\Model\Playlist\PlaylistFindRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Uuid;

class PlaylistType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('identifier', TextType::class, [
                'constraints' => [
                    new NotNull(),
                    new NotBlank(),
                    new Uuid(null, null, [Uuid::V4_RANDOM]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PlaylistFindRequest::class,
            'csrf_protection' => false,
        ]);
    }

}
