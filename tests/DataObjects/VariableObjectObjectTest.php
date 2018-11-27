<?php
declare(strict_types=1);

namespace Tests\App\DataObjects;

use App\Objects\DescriptionObject;
use App\Objects\VariableObject;
use Tests\App\ObjectTestCase;

/**
 * @covers \App\Objects\VariableObject
 */
class VariableObjectObjectTest extends ObjectTestCase
{
    /**
     * Test data object properties.
     *
     * @return void
     */
    public function testProperties(): void
    {
        $variable = new VariableObject();
        $description = new DescriptionObject();

        $variable->setDescription($description);
        $variable->setDisabled(false);
        $variable->setKey('baseUrl');
        $variable->setName('Base Url');
        $variable->setSystem(false);
        $variable->setType('string');
        $variable->setValue('http://my.api.org');

        $this->assertProperties($variable, [
            'getDescription' => $description,
            'isDisabled' => false,
            'getName' => 'Base Url',
            'isSystem' => false,
            'getType' => 'string',
            'getValue' => 'http://my.api.org',
            'getKey' => 'baseUrl'
        ]);
    }

    /**
     * Test data object as array.
     *
     * @return void
     */
    public function testToArray(): void
    {
        $data = [
            'description' => new DescriptionObject(),
            'disabled' => true,
            'key' => 'baseUrl',
            'name' => 'Base Url',
            'system' => false,
            'type' => 'string',
            'value' => 'http://my.api.org'
        ];

        $variable = new VariableObject($data);

        $data['id'] = $variable->getVariableId();

        self::assertEquals($data, $variable->toArray());
        self::assertNotNull($variable->getVariableId());
        self::assertContains(VariableObject::ID_PREFIX, $variable->getVariableId());
    }
}
