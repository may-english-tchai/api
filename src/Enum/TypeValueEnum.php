<?php

namespace App\Enum;

enum TypeValueEnum: string
{
    case string = 'string';
    case integer = 'integer';
    case float = 'float';
    case boolean = 'boolean';
    case array = 'array';
    case object = 'object';
}
