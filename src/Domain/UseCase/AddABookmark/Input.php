<?php

declare(strict_types=1);

namespace App\Domain\UseCase\AddABookmark;

class Input
{
    private string $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
