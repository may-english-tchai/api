<?php

namespace App\Enum;

enum PaymentStatusEnum: string
{
    case unpaid = 'unpaid';
    case processing = 'processing';
    case succeeded = 'succeeded';
    case amount_capturable_updated = 'amount_capturable_updated';
    case payment_failed = 'payment_failed';

    case requires_action = 'requires_action';

    case requires_payment_method = 'requires_payment_method';
}
