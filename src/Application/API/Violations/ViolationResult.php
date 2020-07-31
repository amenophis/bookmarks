<?php

declare(strict_types=1);

namespace App\Application\API\Violations;

use Symfony\Component\Validator\ConstraintViolationInterface;

class ViolationResult implements \JsonSerializable
{
    private string $propertyPath;
    private string $message;

    public function __construct(ConstraintViolationInterface $constraintViolation)
    {
        $this->propertyPath = $constraintViolation->getPropertyPath();
        $this->message      = (string) $constraintViolation->getMessage();
    }

    public function jsonSerialize()
    {
        return [
            'property_path' => $this->propertyPath,
            'message'       => $this->message,
        ];
    }
}
