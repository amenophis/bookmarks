<?php

declare(strict_types=1);

namespace App\Application\API\Exception;

use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class InvalidPayloadException extends \Exception
{
    /**
     * @var ConstraintViolationListInterface<ConstraintViolationInterface>
     */
    private ConstraintViolationListInterface $violations;

    /**
     * @param ConstraintViolationListInterface<ConstraintViolationInterface> $violations
     */
    public function __construct(ConstraintViolationListInterface $violations)
    {
        parent::__construct('The payload is invalid');

        $this->violations = $violations;
    }

    /**
     * @return ConstraintViolationListInterface<ConstraintViolationInterface>
     */
    public function getViolations(): ConstraintViolationListInterface
    {
        return $this->violations;
    }
}
