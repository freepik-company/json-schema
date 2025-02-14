<?php

/*
 * This file is part of the FPJsonSchema package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FPJsonSchema\Tests\Constraints;

class IfThenElseTest extends BaseTestCase
{
    protected $validateSchema = true;

    public function getInvalidTests(): array
    {
        return [
            // If "foo" === "bar", then "bar" must be defined, else Validation Failed.
            // But "foo" === "bar" and "bar" is not defined.
            [
                '{
                  "foo":"bar"
                }',
                '{
                    "type": "object",
                    "properties": {
                        "foo": {"type": "string"},
                        "bar": {"type": "string"}
                    },
                    "if": {
                        "properties": {"foo": {"enum": ["bar"]}},
                        "required": ["foo"]
                    },
                    "then": {"required": ["bar"]},
                    "else": false
                }',
            ],
            // If "foo" === "bar", then "bar" must be defined, else Validation Failed.
            // But "foo" !== "bar".
            [
                '{
                  "foo":"baz"
                }',
                '{
                    "type": "object",
                    "properties": {
                        "foo": {"type": "string"},
                        "bar": {"type": "string"}
                    },
                    "if": {
                        "properties": {"foo": {"enum": ["bar"]}},
                        "required": ["foo"]
                    },
                    "then": {"required": ["bar"]},
                    "else": false
                }',
            ],
            // If "foo" === "bar", then "bar" must === "baz", else Validation Failed.
            // But "foo" === "bar" and "bar" !== "baz".
            [
                '{
                  "foo":"bar",
                  "bar":"potato"
                }',
                '{
                    "type": "object",
                    "properties": {
                        "foo": {"type": "string"},
                        "bar": {"type": "string"}
                    },
                    "if": {
                        "properties": {"foo": {"enum": ["bar"]}},
                        "required": ["foo"]
                    },
                    "then": {
                        "properties": {"bar": {"enum": ["baz"]}},
                        "required": ["bar"]
                    },
                    "else": false
                }',
            ],
            // Always go to "else".
            // But schema is invalid.
            [
                '{
                  "foo":"bar"
                }',
                '{
                    "type": "object",
                    "properties": {
                        "foo": {"type": "string"},
                        "bar": {"type": "string"}
                    },
                    "if": false,
                    "then": true,
                    "else": {
                        "properties": {"bar": {"enum": ["baz"]}},
                        "required": ["bar"]
                    }
                }',
            ],
            // Always go to "then".
            // But schema is invalid.
            [
                '{
                  "foo":"bar"
                }',
                '{
                    "type": "object",
                    "properties": {
                        "foo": {"type": "string"},
                        "bar": {"type": "string"}
                    },
                    "if": true,
                    "then": {
                        "properties": {"bar": {"enum": ["baz"]}},
                        "required": ["bar"]
                    },
                    "else": true
                }',
            ],
        ];
    }

    public function getValidTests(): array
    {
        return [
            // Always validate.
            [
                '{
                  "foo":"bar"
                }',
                '{
                    "type": "object",
                    "properties": {
                        "foo": {"type": "string"},
                        "bar": {"type": "string"}
                    },
                    "if": true,
                    "then": true,
                    "else": false
                }',
            ],
            // Always validate schema in then.
            [
                '{
                  "foo":"bar"
                }',
                '{
                    "type": "object",
                    "properties": {
                        "foo": {"type": "string"},
                        "bar": {"type": "string"}
                    },
                    "if": true,
                    "then": {
                        "properties": {"foo": {"enum": ["bar"]}},
                        "required": ["foo"]
                    },
                    "else": false
                }',
            ],
            // Always validate schema in else.
            [
                '{
                  "foo":"bar"
                }',
                '{
                    "type": "object",
                    "properties": {
                        "foo": {"type": "string"},
                        "bar": {"type": "string"}
                    },
                    "if": false,
                    "then": false,
                    "else": {
                        "properties": {"foo": {"enum": ["bar"]}},
                        "required": ["foo"]
                    }
                }',
            ],
            // "If" is evaluated to true, so "then" is to validate.
            [
                '{
                  "foo":"bar",
                  "bar":"baz"
                }',
                '{
                    "type": "object",
                    "properties": {
                        "foo": {"type": "string"},
                        "bar": {"type": "string"}
                    },
                    "if": {
                        "properties": {"foo": {"enum": ["bar"]}},
                        "required": ["foo"]
                    },
                    "then": {
                        "properties": {"bar": {"enum": ["baz"]}},
                        "required": ["bar"]
                    },
                    "else": false
                }',
            ],
            // "If" is evaluated to false, so "else" is to validate.
            [
                '{
                  "foo":"bar",
                  "bar":"baz"
                }',
                '{
                    "type": "object",
                    "properties": {
                        "foo": {"type": "string"},
                        "bar": {"type": "string"}
                    },
                    "if": {
                        "properties": {"foo": {"enum": ["potato"]}},
                        "required": ["foo"]
                    },
                    "then": false,
                    "else": {
                        "properties": {"bar": {"enum": ["baz"]}},
                        "required": ["bar"]
                    }
                }',
            ],
        ];
    }
}
