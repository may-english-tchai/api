<?php

namespace App\Enum;

enum ConfigEnum: string
{
    case payment_pattern_success = 'payment_pattern_success';
    case payment_pattern_canceled = 'payment_pattern_canceled';
}
