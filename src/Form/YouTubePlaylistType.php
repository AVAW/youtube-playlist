<?php

declare(strict_types=1);

namespace App\Form;

use App\Model\Playlist\PlaylistCreateRequest;
use App\Validator\YouTube\YouTubePlaylistUrl;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Url;

class YouTubePlaylistType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url', TextType::class, [
                'constraints' => [
                    new NotNull(),
                    new Url(),
                    new YouTubePlaylistUrl(),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PlaylistCreateRequest::class,
            'csrf_protection' => false,
        ]);
    }

}
