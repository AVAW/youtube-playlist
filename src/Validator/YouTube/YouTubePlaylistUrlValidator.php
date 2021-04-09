<?php

declare(strict_types=1);

namespace App\Validator\YouTube;

use App\Utils\YouTubePlaylistHelper;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class YouTubePlaylistUrlValidator extends ConstraintValidator
{

    protected YouTubePlaylistHelper $validator;

    public function __construct(YouTubePlaylistHelper $youTubePlaylist)
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
