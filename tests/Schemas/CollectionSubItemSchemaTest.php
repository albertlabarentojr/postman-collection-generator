<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator\Schemas;

use PostmanGenerator\Schemas\ItemSchema;
use PostmanGenerator\Schemas\CollectionSubItemSchema;
use Tests\PostmanGenerator\SchemaTestCase;

/**
 * @covers \PostmanGenerator\Schemas\CollectionSubItemSchema
 */
class CollectionSubItemSchemaTest extends SchemaTestCase
{
    /**
     * Test data object properties.
     *
     * @return void
     */
    public function testProperties(): void
    {
        $subCollection = new CollectionSubItemSchema();
        $item1 = new ItemSchema(['name' => 'item-1']);
        $item2 = new ItemSchema(['name' => 'item-2']);

        $subCollection->setName('Staff Member');
        $subCollection->addItem($item1);
        $subCollection->addItem($item2);

        $this->assertProperties($subCollection, [
            'getName' => 'Staff Member',
            'getItem' => [$item1, $item2]
        ]);
    }

    /**
     * Test data object as array.
     *
     * @return void
     */
    public function testToArray(): void
    {
        $this->assertToObjectArray(CollectionSubItemSchema::class, [
            'name' => 'Staff Member',
            'item' => [new ItemSchema(), new ItemSchema()],
            '_postman_isSubFolder' => true
        ]);
    }
}