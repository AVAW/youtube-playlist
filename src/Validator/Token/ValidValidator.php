<?php

declare(strict_types=1);

namespace App\Validator\Token;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\AbstractComparisonValidator;

class ValidValidator extends AbstractComparisonValidator
{

    /**
     * {@inheritdoc}
     */
    protected function compareValues($value1, $value2): bool
    {
        return $value1 === $value2;
    }

}
