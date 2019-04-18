<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator\Schemas;

use PostmanGenerator\Schemas\DescriptionSchema;
use PostmanGenerator\Schemas\FormParameterSchema;
use Tests\PostmanGenerator\SchemaTestCase;

/**
 * @covers \PostmanGenerator\Schemas\FormParameterSchema
 */
class FormParameterSchemaSchemaTest extends SchemaTestCase
{
    /**
     * Test data object properties.
     *
     * @return void
     */
    public function testProperties(): void
    {
        $formData = new FormParameterSchema();
        $description = new DescriptionSchema();

        $formData->setKey('test-key');
        $formData->setValue('test-value');
        $formData->setDescription($description);
        $formData->setDisabled(false);
        $formData->setContentType('Content-Type');
        $formData->setType('test-type');

        $this->assertProperties($formData, [
            'getKey' => 'test-key',
            'getValue' => 'test-value',
            'getDescription' => $description,
            'isDisabled' => false,
            'getContentType' => 'Content-Type',
            'getType' => 'test-type'
        ]);
    }

    /**
     * Test data object as array.
     *
     * @return void
     */
    public function testToArray(): void
    {
        $this->assertToObjectArray(FormParameterSchema::class, [
            'content_type' => 'Content-Type',
            'description' => new DescriptionSchema(),
            'disabled' => false,
            'key' => 'test-key',
            'type' => 'test-type',
            'value' => 'test-value'
        ]);
    }
}
