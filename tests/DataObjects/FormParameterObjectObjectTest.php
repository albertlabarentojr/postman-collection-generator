<?php
declare(strict_types=1);

namespace Tests\App\DataObjects;

use App\Objects\DescriptionObject;
use App\Objects\FormParameterObject;
use Tests\App\ObjectTestCase;

/**
 * @covers \App\Objects\FormParameterObject
 */
class FormParameterObjectObjectTest extends ObjectTestCase
{
    /**
     * Test data object properties.
     *
     * @return void
     */
    public function testProperties(): void
    {
        $formData = new FormParameterObject();
        $description = new DescriptionObject();

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
        $this->assertToObjectArray(FormParameterObject::class, [
            'content_type' => 'Content-Type',
            'description' => new DescriptionObject(),
            'disabled' => false,
            'key' => 'test-key',
            'type' => 'test-type',
            'value' => 'test-value'
        ]);
    }
}
