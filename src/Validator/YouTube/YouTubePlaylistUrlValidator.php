<?php

namespace App\Validator\YouTube;

use App\Utils\YouTubePlaylist;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class YouTubePlaylistUrlValidator extends ConstraintValidator
{

    protected YouTubePlaylist $validator;

    public function __construct(YouTubePlaylist $youTubePlaylist)
    {
        $this->validator = $youTubePlaylist;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof YouTubePlaylistUrl) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__ . '\NotBlank');
        }

        if (!$this->validator->isValidUrl($value)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }

}
