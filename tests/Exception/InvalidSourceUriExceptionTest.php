<?php

namespace FPJsonSchema\Tests\Exception;

use FPJsonSchema\Exception\InvalidSourceUriException;
use PHPUnit\Framework\TestCase;

class InvalidSourceUriExceptionTest extends TestCase
{
    public function testHierarchy(): void
    {
        $exception = new InvalidSourceUriException();
        self::assertInstanceOf('\InvalidArgumentException', $exception);
        self::assertInstanceOf('\FPJsonSchema\Exception\InvalidArgumentException', $exception);
        self::assertInstanceOf('\FPJsonSchema\Exception\ExceptionInterface', $exception);
    }
}
