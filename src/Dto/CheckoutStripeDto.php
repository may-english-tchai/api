<?php

namespace App\Dto;

use Symfony\Component\Uid\Uuid;

final readonly class CheckoutStripeDto
{
    public function __construct(
        public string $sessionId,
        public ?Uuid $paymentId = null,
        public ?string $url = null,
    ) {
    }
}
