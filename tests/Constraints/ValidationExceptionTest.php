<?php

/*
 * This file is part of the FPJsonSchema package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FPJsonSchema\Tests\Constraints;

use FPJsonSchema\Constraints\Constraint;
use FPJsonSchema\Exception\ValidationException;
use FPJsonSchema\Validator;
use PHPUnit\Framework\TestCase;

class ValidationExceptionTest extends TestCase
{
    public function testValidationException(): void
    {
        $exception = new ValidationException();
        $this->assertInstanceOf('\FPJsonSchema\Exception\ValidationException', $exception);

        $checkValue = json_decode('{"propertyOne": "thisIsNotAnObject"}');
        $schema = json_decode('{
            "type": "object",
            "additionalProperties": false,
            "properties": {
                "propertyOne": {
                    "type": "object"
                }
            }
        }');

        $validator = new Validator();

        try {
            $validator->validate($checkValue, $schema, Constraint::CHECK_MODE_EXCEPTIONS);
        } catch (\Exception $e) {
            $exception = $e;
        }

        $this->assertEquals(
            'Error validating /propertyOne: String value found, but an object is required',
            $exception->getMessage()
        );

        $this->expectException('FPJsonSchema\Exception\ValidationException');
        throw $exception;
    }
}
