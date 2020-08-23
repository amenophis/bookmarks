<?php

declare(strict_types=1);

namespace App\Domain\Data\Model\Exception;

class KeywordDoesntExistsException extends \Exception
{
    public function __construct(string $keyword)
    {
        parent::__construct("Keyword \"{$keyword}\" does not exists");
    }
}
