<?php

namespace App\Enum;

enum PaymentStatusEnum: string
{
    case unpaid = 'unpaid';
    case paid = 'paid';
}
