<?php

namespace FPJsonSchema\Tests\Exception;

use FPJsonSchema\Exception\InvalidSchemaMediaTypeException;
use PHPUnit\Framework\TestCase;

class InvalidSchemaMediaTypeExceptionTest extends TestCase
{
    public function testHierarchy(): void
    {
        $exception = new InvalidSchemaMediaTypeException();
        self::assertInstanceOf('\RuntimeException', $exception);
        self::assertInstanceOf('\FPJsonSchema\Exception\RuntimeException', $exception);
        self::assertInstanceOf('\FPJsonSchema\Exception\ExceptionInterface', $exception);
    }
}
