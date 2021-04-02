<?php

namespace App\Validator\YouTube;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class YouTubePlaylistUrl extends Constraint
{

    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public string $message = 'This value is not a valid YouTube playlist URL.';

}
