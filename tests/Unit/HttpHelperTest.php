<?php

namespace App\Tests\Unit;

use App\Helper\HttpHelper;
use PHPUnit\Framework\TestCase;

class HttpHelperTest extends TestCase
{
    public function testRefererUrlWithTrailingSlash(): void
    {
        $url = HttpHelper::clear('https://may-english-tchai.com/');
        static::assertSame($url, 'https://may-english-tchai.com');
    }
}
