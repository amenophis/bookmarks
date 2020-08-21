<?php

declare(strict_types=1);

namespace App\Application\API\Action\RemoveBookmark;

use App\Application\API\ResultInterface;

class Result implements ResultInterface
{
    public function jsonSerialize(): void
    {
    }
}
