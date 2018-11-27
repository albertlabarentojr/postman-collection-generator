<?php
declare(strict_types=1);

namespace Tests\App\DataObjects;

use App\Objects\AuthObject;
use App\Objects\CollectionItemObject;
use App\Objects\CollectionObject;
use App\Objects\InfoObject;
use App\Objects\VariableObject;
use Tests\App\ObjectTestCase;

class CollectionObjectTest extends ObjectTestCase
{
    /**
     * Test data object properties.
     *
     * @return void
     */
    public function testProperties(): void
    {
        $collection = new CollectionObject();
        $info = new InfoObject();
        $item1 = new CollectionItemObject();
        $item2 = new CollectionItemObject();
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
