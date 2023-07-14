<?php

namespace App\Helper;

use function Symfony\Component\String\u;

class HttpHelper
{
    public static function clear(string $url): string
    {
        return u($url)
            ->replaceMatches('/[\/]+$/', '')
            ->toString()
        ;
    }
}
