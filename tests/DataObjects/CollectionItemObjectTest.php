<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator\DataObjects;

use PostmanGenerator\Objects\CollectionItemObject;
use PostmanGenerator\Objects\CollectionSubItemObject;
use Tests\PostmanGenerator\ObjectTestCase;

/**
 * @covers \PostmanGenerator\Objects\CollectionItemObject
 */
class CollectionItemObjectTest extends ObjectTestCase
{
    /**
     * Test data object properties.
     *
     * @return void
     */
    public function testProperties(): void
    {
        $collection = new CollectionItemObject();
        $subItem1 = new CollectionSubItemObject(['name' => 'item-1']);
        $subItem2 = new CollectionSubItemObject(['name' => 'item-2']);

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
        $this->assertToObjectArray(CollectionItemObject::class, [
            'name' => 'Address',
            'description' => 'Description as string',
            'item' => [new CollectionSubItemObject(), new CollectionSubItemObject()]
        ]);
    }
}
