<?php

declare(strict_types=1);

namespace App\Application\API\Violations;

use Symfony\Component\Validator\ConstraintViolationInterface;

class ViolationResult
{
    public string $propertyPath;
    public string $message;

    public function __construct(ConstraintViolationInterface $constraintViolation)
    {
        $this->propertyPath = $constraintViolation->getPropertyPath();
        $this->message      = (string) $constraintViolation->getMessage();
    }
}
