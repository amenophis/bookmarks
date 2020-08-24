<?php

declare(strict_types=1);

namespace App\Application\API\Action\CreateBookmark;

use App\Application\API\PayloadInterface;
use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Constraints as Assert;

class Payload implements PayloadInterface
{
    /**
     * @Assert\NotBlank()
     * @Assert\Url()
     *
     * @OA\Property(type="string");
     */
    public ?string $url = null;
}
