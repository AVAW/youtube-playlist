<?php

declare(strict_types=1);

namespace App\Validator\YouTube;

use App\Http\YouTube\PlaylistClient;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class YouTubePlaylistUrlValidator extends ConstraintValidator
{

    protected PlaylistClient $validator;

    public function __construct(
        PlaylistClient $playlistClient
    ) {
        $this->validator = $playlistClient;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof YouTubePlaylistUrl) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__ . '\NotBlank');
        }

        if (null === $value || '' === $value) {
            return;
        }

        try {
            $this->validator->isValidUrl($value);
        } catch (\Throwable $e) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }

}
