<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator\DataObjects;

use PostmanGenerator\Objects\ItemObject;
use PostmanGenerator\Objects\CollectionSubItemObject;
use Tests\PostmanGenerator\ObjectTestCase;

/**
 * @covers \PostmanGenerator\Objects\CollectionSubItemObject
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
        $item1 = new ItemObject(['name' => 'item-1']);
        $item2 = new ItemObject(['name' => 'item-2']);

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