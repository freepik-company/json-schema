<?php

namespace FPJsonSchema\Tests\Exception;

use FPJsonSchema\Exception\UriResolverException;
use PHPUnit\Framework\TestCase;

class UriResolverExceptionTest extends TestCase
{
    public function testHierarchy(): void
    {
        $exception = new UriResolverException();
        self::assertInstanceOf('\RuntimeException', $exception);
        self::assertInstanceOf('\FPJsonSchema\Exception\RuntimeException', $exception);
        self::assertInstanceOf('\FPJsonSchema\Exception\ExceptionInterface', $exception);
    }
}
