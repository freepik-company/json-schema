<?php

/*
 * This file is part of the FPJsonSchema package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FPJsonSchema\Constraints;

use FPJsonSchema\ConstraintError;
use FPJsonSchema\Entity\JsonPointer;

/**
 * The Constraints Interface
 *
 * @author Robert Schönthal <seroscho@googlemail.com>
 */
interface ConstraintInterface
{
    /**
     * returns all collected errors
     *
     * @return array
     */
    public function getErrors();

    /**
     * adds errors to this validator
     *
     * @param array $errors
     */
    public function addErrors(array $errors);

    /**
     * adds an error
     *
     * @param ConstraintError  $constraint the constraint/rule that is broken, e.g.: ConstraintErrors::LENGTH_MIN()
     * @param JsonPointer|null $path
     * @param array            $more       more array elements to add to the error
     */
    public function addError(ConstraintError $constraint, ?JsonPointer $path = null, array $more = []);

    /**
     * checks if the validator has not raised errors
     *
     * @return bool
     */
    public function isValid();

    /**
     * invokes the validation of an element
     *
     * @abstract
     *
     * @param mixed            $value
     * @param mixed            $schema
     * @param JsonPointer|null $path
     * @param mixed            $i
     *
     * @throws \FPJsonSchema\Exception\ExceptionInterface
     */
    public function check(&$value, $schema = null, ?JsonPointer $path = null, $i = null);
}
