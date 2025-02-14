<?php

/*
 * This file is part of the FPJsonSchema package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FPJsonSchema\Tests;

use FPJsonSchema\ConstraintError;
use PHPUnit\Framework\TestCase;

class ConstraintErrorTest extends TestCase
{
    public function testGetValidMessage(): void
    {
        $e = ConstraintError::ALL_OF();
        $this->assertEquals('Failed to match all schemas', $e->getMessage());
    }

    public function testGetInvalidMessage(): void
    {
        $e = ConstraintError::MISSING_ERROR();

        $this->expectException('\FPJsonSchema\Exception\InvalidArgumentException');
        $this->expectExceptionMessage('Missing error message for missingError');

        $e->getMessage();
    }
}
