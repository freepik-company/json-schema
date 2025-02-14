<?php

namespace FPJsonSchema\Tests\Exception;

use FPJsonSchema\Exception\RuntimeException;
use PHPUnit\Framework\TestCase;

class RuntimeExceptionTest extends TestCase
{
    public function testHierarchy(): void
    {
        $exception = new RuntimeException();
        self::assertInstanceOf('\RuntimeException', $exception);
        self::assertInstanceOf('\FPJsonSchema\Exception\ExceptionInterface', $exception);
    }
}
