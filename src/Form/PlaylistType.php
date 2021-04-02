<?php

namespace App\Form;

use App\Entity\Playlist;
use App\Validator\YouTube\YouTubePlaylistUrl;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Url;

class PlaylistType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url', TextType::class, [
                'label' => 'playlist.url',
                'attr' => [
                    'placeholder' => 'playlist.realUrl',
                ],
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
            'data_class' => Playlist::class,
        ]);
    }

}
