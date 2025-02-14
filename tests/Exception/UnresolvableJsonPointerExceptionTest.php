<?php

namespace FPJsonSchema\Tests\Exception;

use FPJsonSchema\Exception\UnresolvableJsonPointerException;
use PHPUnit\Framework\TestCase;

class UnresolvableJsonPointerExceptionTest extends TestCase
{
    public function testHierarchy(): void
    {
        $exception = new UnresolvableJsonPointerException();
        self::assertInstanceOf('\InvalidArgumentException', $exception);
        self::assertInstanceOf('\FPJsonSchema\Exception\InvalidArgumentException', $exception);
        self::assertInstanceOf('\FPJsonSchema\Exception\ExceptionInterface', $exception);
    }
}
