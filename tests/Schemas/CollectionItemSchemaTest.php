<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator\Schemas;

use PostmanGenerator\Schemas\CollectionItemSchema;
use PostmanGenerator\Schemas\CollectionSubItemSchema;
use Tests\PostmanGenerator\SchemaTestCase;

/**
 * @covers \PostmanGenerator\Schemas\CollectionItemSchema
 */
class CollectionItemSchemaTest extends SchemaTestCase
{
    /**
     * Test data object properties.
     *
     * @return void
     */
    public function testProperties(): void
    {
        $collection = new CollectionItemSchema();
        $subItem1 = new CollectionSubItemSchema(['name' => 'item-1']);
        $subItem2 = new CollectionSubItemSchema(['name' => 'item-2']);

        $collection->setName('Address');
        $collection->addItem($subItem1);
        $collection->addItem($subItem2);
        $collection->setDescription('Description as string');

        $this->assertProperties($collection, [
            'getName' => 'Address',
            'getDescription' => 'Description as string',
            'getItem' => [$subItem1, $subItem2]
        ]);
    }

    /**
     * Test data object as array.
     *
     * @return void
     */
    public function testToArray(): void
    {
        $this->assertToObjectArray(CollectionItemSchema::class, [
            'name' => 'Address',
            'description' => 'Description as string',
            'item' => [new CollectionSubItemSchema(), new CollectionSubItemSchema()]
        ]);
    }
}
