<?php

declare(strict_types=1);

namespace App\Application\API;

interface ResultInterface extends \JsonSerializable
{
    public function getStatusCode(): int;
}
