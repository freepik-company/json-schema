<?php

namespace FPJsonSchema\Tests\Exception;

use FPJsonSchema\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class InvalidArgumentExceptionTest extends TestCase
{
    public function testHierarchy(): void
    {
        $exception = new InvalidArgumentException();
        self::assertInstanceOf('\InvalidArgumentException', $exception);
        self::assertInstanceOf('\FPJsonSchema\Exception\ExceptionInterface', $exception);
    }
}
