<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator\Schemas;

use PostmanGenerator\Schemas\DescriptionSchema;
use PostmanGenerator\Schemas\VariableSchema;
use Tests\PostmanGenerator\SchemaTestCase;

/**
 * @covers \PostmanGenerator\Schemas\VariableSchema
 */
class VariableSchemaTest extends SchemaTestCase
{
    /**
     * Test data object properties.
     *
     * @return void
     */
    public function testProperties(): void
    {
        $variable = new VariableSchema();
        $description = new DescriptionSchema();

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
            'description' => new DescriptionSchema(),
            'disabled' => true,
            'key' => 'baseUrl',
            'name' => 'Base Url',
            'system' => false,
            'type' => 'string',
            'value' => 'http://my.api.org'
        ];

        $variable = new VariableSchema($data);

        $data['id'] = $variable->getVariableId();

        self::assertEquals($data, $variable->toArray());
        self::assertNotNull($variable->getVariableId());
        self::assertContains(VariableSchema::ID_PREFIX, $variable->getVariableId());
    }
}
