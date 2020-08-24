<?php

declare(strict_types=1);

namespace App\Application\API;

interface ResultInterface
{
    /**
     * @return mixed
     */
    public function getResponse();
}
