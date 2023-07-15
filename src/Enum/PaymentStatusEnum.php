<?php

namespace App\Enum;

enum PaymentStatusEnum: string
{
    case paid = 'paid';
    case unpaid = 'unpaid';
}
