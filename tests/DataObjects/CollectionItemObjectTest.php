<?php
declare(strict_types=1);

namespace Tests\App\DataObjects;

use App\Objects\CollectionItemObject;
use App\Objects\CollectionSubItemObject;
use Tests\App\ObjectTestCase;

/**
 * @covers \App\Objects\CollectionItemObject
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
        $subItem1 = new CollectionSubItemObject();
        $subItem2 = new CollectionSubItemObject();

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
