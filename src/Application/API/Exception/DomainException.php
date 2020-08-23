<?php

declare(strict_types=1);

namespace App\Application\API\Exception;

class DomainException extends \Exception
{
    public function __construct(\Exception $e)
    {
        parent::__construct($e->getMessage(), 0, $e);
    }
}
