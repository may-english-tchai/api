<?php

namespace App\Enum;

enum PaymentStatusEnum: string
{
    case prepare = 'prepare';
    case paid = 'paid';
    case unpaid = 'unpaid';
}
