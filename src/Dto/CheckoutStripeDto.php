<?php

namespace App\Dto;

final readonly class CheckoutStripeDto
{
    public function __construct(
        public string $sessionId,
        public ?string $url = null,
    ) {
    }
}
