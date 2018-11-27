<?php
declare(strict_types=1);

namespace Tests\App\DataObjects;

use App\Objects\DescriptionObject;
use App\Objects\HeaderObject;
use Tests\App\ObjectTestCase;

/**
 * @covers  \App\Objects\HeaderObject
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
