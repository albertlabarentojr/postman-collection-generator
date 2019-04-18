<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator\Schemas;

use PostmanGenerator\Schemas\DescriptionSchema;
use Tests\PostmanGenerator\SchemaTestCase;

/**
 * @covers \PostmanGenerator\Schemas\DescriptionSchema
 */
class DescriptionSchemaTest extends SchemaTestCase
{
    /**
     * Test description properties.
     *
     * @return void
     */
    public function testProperties(): void
    {
        $description = new DescriptionSchema();

        $description->setType('type-test');
        $description->setContent('content-test');

        $this->assertProperties($description, ['getType' => 'type-test', 'getContent' => 'content-test']);
    }

    /**
     * Test description with default type.
     */
    public function testGetDescriptionWithDefaultType(): void
    {
        $description = new DescriptionSchema();

        self::assertEquals('text/markdown', $description->getType());
    }

    /**
     * Test object to array.
     *
     * @return void
     */
    public function testToArray(): void
    {
        $this->assertToObjectArray(DescriptionSchema::class, [
            'content' => 'content-test',
            'type' => 'type-test'
        ]);
    }
}
