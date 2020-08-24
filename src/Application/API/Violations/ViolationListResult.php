<?php

declare(strict_types=1);

namespace App\Application\API\Violations;

use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ViolationListResult
{
    /**
     * @var ViolationResult[]
     */
    public array $violations = [];

    /**
     * @param ConstraintViolationListInterface<ConstraintViolationInterface> $validationErrors
     */
    public function __construct(ConstraintViolationListInterface $validationErrors)
    {
        foreach ($validationErrors as $validationError) {
            $this->violations[] = new ViolationResult($validationError);
        }
    }
}
