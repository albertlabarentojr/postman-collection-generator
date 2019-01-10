<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator\DataObjects;

use PostmanGenerator\Objects\AuthObject;
use PostmanGenerator\Objects\CollectionItemObject;
use PostmanGenerator\Objects\CollectionObject;
use PostmanGenerator\Objects\InfoObject;
use PostmanGenerator\Objects\ItemObject;
use PostmanGenerator\Objects\VariableObject;
use Tests\PostmanGenerator\ObjectTestCase;

class CollectionObjectTest extends ObjectTestCase
{
    /**
     * Test add items.
     *
     * @return void
     */
    public function testAddItems(): void
    {
        $collection = new CollectionObject();
        $item1 = new CollectionItemObject(['name' => 'c-1']);
        $item2 = new CollectionItemObject(['name' => 'c-2']);
        $item3 = new CollectionObject(['name' => 'c-2']);
        $item4 = new ItemObject(['name' => 'c-3']);

        $collection->addItems([$item1, $item2, $item3, $item4]);

        self::assertCount(2, $collection->getItem());
    }

    /**
     * Test data object properties.
     *
     * @return void
     */
    public function testProperties(): void
    {
        $collection = new CollectionObject();
        $info = new InfoObject();
        $item1 = new CollectionItemObject(['name' => 'c-1']);
        $item2 = new CollectionItemObject(['name' => 'c-2']);
        $auth = new AuthObject();
        $variable1 = new VariableObject();
        $variable2 = new VariableObject();

        $collection->setInfo($info);
        $collection->addItem($item1);
        $collection->addItem($item2);
        $collection->setAuth($auth);
        $collection->addVariable($variable1);
        $collection->addVariable($variable2);

        $this->assertProperties($collection, [
            'getInfo' => $info,
            'getItem' => [$item1, $item2],
            'getAuth' => $auth,
            'getVariable' => [$variable1, $variable2]
        ]);
    }

    /**
     * Test data object as array.
     *
     * @return void
     */
    public function testToArray(): void
    {
        $this->assertToObjectArray(CollectionObject::class, [
            'info' => new InfoObject(),
            'item' => [new CollectionItemObject(), new CollectionItemObject()],
            'auth' => new AuthObject(),
            'variable' => [new VariableObject(), new VariableObject()]
        ]);
    }
}
