<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class PasswordUserDto
{
    public function __construct(
        #[Assert\NotBlank]
        public string $currentPassword,

        #[Assert\NotBlank]
        #[Assert\Length(8)]
        public string $newPassword,
    ) {
    }
}
