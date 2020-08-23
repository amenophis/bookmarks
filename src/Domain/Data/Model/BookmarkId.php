<?php

declare(strict_types=1);

namespace App\Domain\Data\Model;

use Webmozart\Assert\Assert;

class BookmarkId
{
    private string $id;

    public function __construct(string $id)
    {
        Assert::uuid($id);

        $this->id = $id;
    }

    public static function fromString(string $id): self
    {
        return new self($id);
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
