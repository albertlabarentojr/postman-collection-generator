<?php
declare(strict_types=1);

namespace Tests\App\DataObjects;

use App\Objects\ItemObject;
use App\Objects\CollectionSubItemObject;
use Tests\App\ObjectTestCase;

/**
 * @covers \App\Objects\CollectionSubItemObject
 */
class CollectionSubItemObjectTest extends ObjectTestCase
{
    /**
     * Test data object properties.
     *
     * @return void
     */
    public function testProperties(): void
    {
        $subCollection = new CollectionSubItemObject();
        $item1 = new ItemObject();
        $item2 = new ItemObject();

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
        $this->assertToObjectArray(CollectionSubItemObject::class, [
            'name' => 'Staff Member',
            'item' => [new ItemObject(), new ItemObject()],
            '_postman_isSubFolder' => true
        ]);
    }
}