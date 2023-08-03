<?php

namespace App\Enum;

enum NotificationTypeEnum: string
{
    case error = 'error';
    case success = 'success';
    case info = 'info';
    case warning = 'warning';
    case notice = 'notice';
}
