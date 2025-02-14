<?php

namespace FPJsonSchema\Tests\Exception;

use FPJsonSchema\Exception\ResourceNotFoundException;
use PHPUnit\Framework\TestCase;

class ResourceNotFoundExceptionTest extends TestCase
{
    public function testHierarchy(): void
    {
        $exception = new ResourceNotFoundException();
        self::assertInstanceOf('\RuntimeException', $exception);
        self::assertInstanceOf('\FPJsonSchema\Exception\RuntimeException', $exception);
        self::assertInstanceOf('\FPJsonSchema\Exception\ExceptionInterface', $exception);
    }
}
