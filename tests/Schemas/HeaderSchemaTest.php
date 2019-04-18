<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator\Schemas;

use PostmanGenerator\Schemas\DescriptionSchema;
use PostmanGenerator\Schemas\HeaderSchema;
use Tests\PostmanGenerator\SchemaTestCase;

/**
 * @covers  \PostmanGenerator\Schemas\HeaderSchema
 */
class HeaderSchemaTest extends SchemaTestCase
{
    /**
     * Test data object properties.
     *
     * @return void
     */
    public function testProperties(): void
    {
        $header = new HeaderSchema();
        $description = new DescriptionSchema();

        $header->setDescription($description);
        $header->setDisabled(true);
        $header->setKey('Connection');
        $header->setValue('keep-alive');

        $this->assertProperties($header, [
            'getDescription' => $description,
            'isDisabled' => true,
            'getKey' => 'Connection',
            'getValue' => 'keep-alive'
        ]);
    }

    /**
     * Test data object as array.
     *
     * @return void
     */
    public function testToArray(): void
    {
        $this->assertToObjectArray(HeaderSchema::class, [
            'description' => new DescriptionSchema(),
            'disabled' => false,
            'key' => 'Connection',
            'value' => 'keep-alive',
            'name' => 'Connection'
        ]);
    }
}
