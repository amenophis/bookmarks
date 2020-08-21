<?php

declare(strict_types=1);

namespace App\Application\API\Exception;

class NotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Not found');
    }
}
