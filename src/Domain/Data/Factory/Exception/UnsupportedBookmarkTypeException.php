<?php

declare(strict_types=1);

namespace App\Domain\Data\Factory\Exception;

class UnsupportedBookmarkTypeException extends \Exception
{
    public function __construct(string $type)
    {
        parent::__construct("Unsupported bookmark type: \"{$type}\".");
    }
}
