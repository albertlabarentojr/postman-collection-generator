<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator\Schemas;

use PostmanGenerator\Schemas\AuthSchema;
use PostmanGenerator\Schemas\CollectionItemSchema;
use PostmanGenerator\Schemas\CollectionSchema;
use PostmanGenerator\Schemas\InfoSchema;
use PostmanGenerator\Schemas\ItemSchema;
use PostmanGenerator\Schemas\VariableSchema;
use Tests\PostmanGenerator\SchemaTestCase;

class CollectionSchemaTest extends SchemaTestCase
{
    /**
     * Test add items.
     *
     * @return void
     */
    public function testAddItems(): void
    {
        $collection = new CollectionSchema();
        $item1 = new CollectionItemSchema(['name' => 'c-1']);
        $item2 = new CollectionItemSchema(['name' => 'c-2']);
        $item3 = new CollectionSchema(['name' => 'c-2']);
        $item4 = new ItemSchema(['name' => 'c-3']);

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
        $collection = new CollectionSchema();
        $info = new InfoSchema();
        $item1 = new CollectionItemSchema(['name' => 'c-1']);
        $item2 = new CollectionItemSchema(['name' => 'c-2']);
        $auth = new AuthSchema();
        $variable1 = new VariableSchema();
        $variable2 = new VariableSchema();

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
        $this->assertToObjectArray(CollectionSchema::class, [
            'info' => new InfoSchema(),
            'item' => [new CollectionItemSchema(), new CollectionItemSchema()],
            'auth' => new AuthSchema(),
            'variable' => [new VariableSchema(), new VariableSchema()]
        ]);
    }
}
