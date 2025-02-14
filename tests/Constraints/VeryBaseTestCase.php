<?php

/*
 * This file is part of the FPJsonSchema package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FPJsonSchema\Tests\Constraints;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

/**
 * @package FPJsonSchema\Tests\Constraints
 */
abstract class VeryBaseTestCase extends TestCase
{
    /** @var object */
    private $FPJsonSchemaDraft03;

    /** @var object */
    private $FPJsonSchemaDraft04;

    /**
     * @param object $schema
     */
    protected function getUriRetrieverMock($schema): object
    {
        $relativeTestsRoot = realpath(__DIR__ . '/../../vendor/json-schema/json-schema-test-suite/remotes');

        $FPJsonSchemaDraft03 = $this->getFPJsonSchemaDraft03();
        $FPJsonSchemaDraft04 = $this->getFPJsonSchemaDraft04();

        $uriRetriever = $this->prophesize('FPJsonSchema\UriRetrieverInterface');
        $uriRetriever->retrieve('http://www.my-domain.com/schema.json')
            ->willReturn($schema)
            ->shouldBeCalled();

        $uriRetriever->retrieve(Argument::any())
            ->will(function ($args) use ($FPJsonSchemaDraft03, $FPJsonSchemaDraft04, $relativeTestsRoot) {
                if ('http://json-schema.org/draft-03/schema' === $args[0]) {
                    return $FPJsonSchemaDraft03;
                } elseif ('http://json-schema.org/draft-04/schema' === $args[0]) {
                    return $FPJsonSchemaDraft04;
                } elseif (0 === strpos($args[0], 'http://localhost:1234')) {
                    $urlParts = parse_url($args[0]);

                    return json_decode(file_get_contents($relativeTestsRoot . $urlParts['path']));
                } elseif (0 === strpos($args[0], 'http://www.my-domain.com')) {
                    $urlParts = parse_url($args[0]);

                    return json_decode(file_get_contents($relativeTestsRoot . '/folder' . $urlParts['path']));
                }
            });

        return $uriRetriever->reveal();
    }

    private function getFPJsonSchemaDraft03(): object
    {
        if (!$this->FPJsonSchemaDraft03) {
            $this->FPJsonSchemaDraft03 = json_decode(
                file_get_contents(__DIR__ . '/../../dist/schema/json-schema-draft-03.json')
            );
        }

        return $this->FPJsonSchemaDraft03;
    }

    private function getFPJsonSchemaDraft04(): object
    {
        if (!$this->FPJsonSchemaDraft04) {
            $this->FPJsonSchemaDraft04 = json_decode(
                file_get_contents(__DIR__ . '/../../dist/schema/json-schema-draft-04.json')
            );
        }

        return $this->FPJsonSchemaDraft04;
    }
}
