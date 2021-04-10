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
use Symfony\Contracts\Translation\TranslatorInterface;

class YouTubePlaylistType extends AbstractType
{

    private TranslatorInterface $translator;

    public function __construct(
        TranslatorInterface $translator
    ) {
        $this->translator = $translator;
    }

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
                    new Url(null, $this->translator->trans('playlist.error.invalidUrl')),
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
