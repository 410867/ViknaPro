<?php

namespace App\Object\Exception;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

final class ValidationFailedException extends BadRequestHttpException
{
    public function __construct(ConstraintViolationListInterface $constraints)
    {
        $errors = [];
        foreach ($constraints as $constraint) {
            $errors[] =
                $constraint->getPropertyPath() ?
                    '(' . $constraint->getPropertyPath() . ') ' . $constraint->getMessage() :
                    $constraint->getMessage();
        }

        parent::__construct('Validation failed: ' . implode('; ', $errors), null, 0, []);
    }
}