<?php

declare(strict_types=1);

namespace App\Validator\Token;

use Symfony\Component\Validator\Constraints\AbstractComparison;

/**
 * @Annotation
 */
class Valid extends AbstractComparison
{

    /**
     * @var string
     */
    public $message = 'The value is not valid.';

}
