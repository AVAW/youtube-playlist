<?php

declare(strict_types=1);

namespace App\Utils\Form;

use Symfony\Component\Form\FormInterface;

class FormErrorHelper
{

    public static function errorsToArray(FormInterface $form): array
    {
        $errors = [];
        foreach ($form as $fieldName => $formField) {
            foreach ($formField->getErrors(true) as $error) {
                $errors[$fieldName] = $error->getMessage();
            }
        }

        return $errors;
    }

}
