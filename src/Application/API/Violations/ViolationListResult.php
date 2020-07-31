<?php

declare(strict_types=1);

namespace App\Application\API\Violations;

use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ViolationListResult implements \JsonSerializable
{
    /**
     * @var ViolationResult[]
     */
    public $violations = [];

    /**
     * @param ConstraintViolationListInterface<ConstraintViolationInterface> $validationErrors
     */
    public function __construct(ConstraintViolationListInterface $validationErrors)
    {
        foreach ($validationErrors as $validationError) {
            $this->violations[] = new ViolationResult($validationError);
        }
    }

    public function jsonSerialize()
    {
        return [
            'violations' => $this->violations,
        ];
    }
}
