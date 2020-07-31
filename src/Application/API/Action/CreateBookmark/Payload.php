<?php

declare(strict_types=1);

namespace App\Application\API\Action\CreateBookmark;

use App\Application\API\PayloadInterface;
use Symfony\Component\Validator\Constraints as Assert;

class Payload implements PayloadInterface
{
    /**
     * @Assert\NotBlank()
     * @Assert\Url()
     */
    public ?string $url = null;
}
