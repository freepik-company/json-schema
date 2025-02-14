<?php

/*
 * This file is part of the FPJsonSchema package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FPJsonSchema\Tests\Constraints;

use FPJsonSchema\Constraints\Constraint;
use FPJsonSchema\Constraints\Factory;
use FPJsonSchema\Entity\JsonPointer;
use PHPUnit\Framework\TestCase;

/**
 * Class MyBadConstraint
 *
 * @package FPJsonSchema\Tests\Constraints
 */
class MyBadConstraint
{
}

/**
 * Class MyStringConstraint
 *
 * @package FPJsonSchema\Tests\Constraints
 */
class MyStringConstraint extends Constraint
{
    public function check(&$value, $schema = null, ?JsonPointer $path = null, $i = null)
    {
    }
}

class FactoryTest extends TestCase
{
    /**
     * @var Factory
     */
    protected $factory;

    protected function setUp(): void
    {
        $this->factory = new Factory();
    }

    /**
     * @dataProvider constraintNameProvider
     *
     * @param string $constraintName
     * @param string $expectedClass
     */
    public function testCreateInstanceForConstraintName($constraintName, $expectedClass): void
    {
        $constraint = $this->factory->createInstanceFor($constraintName);

        $this->assertInstanceOf($expectedClass, $constraint);
        $this->assertInstanceOf('FPJsonSchema\Constraints\ConstraintInterface', $constraint);
    }

    public function constraintNameProvider(): array
    {
        return [
            ['array', 'FPJsonSchema\Constraints\CollectionConstraint'],
            ['collection', 'FPJsonSchema\Constraints\CollectionConstraint'],
            ['object', 'FPJsonSchema\Constraints\ObjectConstraint'],
            ['type', 'FPJsonSchema\Constraints\TypeConstraint'],
            ['undefined', 'FPJsonSchema\Constraints\UndefinedConstraint'],
            ['string', 'FPJsonSchema\Constraints\StringConstraint'],
            ['number', 'FPJsonSchema\Constraints\NumberConstraint'],
            ['enum', 'FPJsonSchema\Constraints\EnumConstraint'],
            ['const', 'FPJsonSchema\Constraints\ConstConstraint'],
            ['format', 'FPJsonSchema\Constraints\FormatConstraint'],
            ['schema', 'FPJsonSchema\Constraints\SchemaConstraint'],
        ];
    }

    /**
     * @dataProvider invalidConstraintNameProvider
     *
     * @param string $constraintName
     */
    public function testExceptionWhenCreateInstanceForInvalidConstraintName($constraintName): void
    {
        $this->expectException('FPJsonSchema\Exception\InvalidArgumentException');
        $this->factory->createInstanceFor($constraintName);
    }

    public function invalidConstraintNameProvider(): array
    {
        return [
            ['invalidConstraintName'],
        ];
    }

    public function testSetConstraintClassExistsCondition(): void
    {
        $this->expectException(\FPJsonSchema\Exception\InvalidArgumentException::class);

        $this->factory->setConstraintClass('string', 'SomeConstraint');
    }

    public function testSetConstraintClassImplementsCondition(): void
    {
        $this->expectException(\FPJsonSchema\Exception\InvalidArgumentException::class);

        $this->factory->setConstraintClass('string', 'FPJsonSchema\Tests\Constraints\MyBadConstraint');
    }

    public function testSetConstraintClassInstance(): void
    {
        $this->factory->setConstraintClass('string', 'FPJsonSchema\Tests\Constraints\MyStringConstraint');
        $constraint = $this->factory->createInstanceFor('string');
        $this->assertInstanceOf('FPJsonSchema\Tests\Constraints\MyStringConstraint', $constraint);
        $this->assertInstanceOf('FPJsonSchema\Constraints\ConstraintInterface', $constraint);
    }

    public function testCheckMode(): void
    {
        $f = new Factory();

        // test default value
        $this->assertEquals(Constraint::CHECK_MODE_NORMAL, $f->getConfig());

        // test overriding config
        $f->setConfig(Constraint::CHECK_MODE_COERCE_TYPES);
        $this->assertEquals(Constraint::CHECK_MODE_COERCE_TYPES, $f->getConfig());

        // test adding config
        $f->addConfig(Constraint::CHECK_MODE_NORMAL);
        $this->assertEquals(Constraint::CHECK_MODE_NORMAL | Constraint::CHECK_MODE_COERCE_TYPES, $f->getConfig());

        // test getting filtered config
        $this->assertEquals(Constraint::CHECK_MODE_NORMAL, $f->getConfig(Constraint::CHECK_MODE_NORMAL));

        // test removing config
        $f->removeConfig(Constraint::CHECK_MODE_COERCE_TYPES);
        $this->assertEquals(Constraint::CHECK_MODE_NORMAL, $f->getConfig());

        // test resetting to defaults
        $f->setConfig(Constraint::CHECK_MODE_COERCE_TYPES | Constraint::CHECK_MODE_TYPE_CAST);
        $f->setConfig();
        $this->assertEquals(Constraint::CHECK_MODE_NORMAL, $f->getConfig());
    }
}
