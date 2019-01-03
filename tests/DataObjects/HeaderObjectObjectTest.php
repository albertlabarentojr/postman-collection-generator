<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator\DataObjects;

use PostmanGenerator\Objects\DescriptionObject;
use PostmanGenerator\Objects\HeaderObject;
use Tests\PostmanGenerator\ObjectTestCase;

/**
 * @covers  \PostmanGenerator\Objects\HeaderObject
 */
class HeaderObjectObjectTest extends ObjectTestCase
{
    /**
     * Test data object properties.
     *
     * @return void
     */
    public function testProperties(): void
    {
        $header = new HeaderObject();
        $description = new DescriptionObject();

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
        $this->assertToObjectArray(HeaderObject::class, [
            'description' => new DescriptionObject(),
            'disabled' => false,
            'key' => 'Connection',
            'value' => 'keep-alive',
            'name' => 'Connection'
        ]);
    }
}
