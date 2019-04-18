<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator\Schemas;

use PostmanGenerator\Schemas\ItemSchema;
use PostmanGenerator\Schemas\RequestSchema;
use PostmanGenerator\Schemas\ResponseSchema;
use Tests\PostmanGenerator\SchemaTestCase;

class ItemSchemaTest extends SchemaTestCase
{
    /**
     * Test data object properties.
     *
     * @return void
     */
    public function testProperties(): void
    {
        $item = new ItemSchema();
        $request = new RequestSchema();
        $response1 = new ResponseSchema();
        $response2 = new ResponseSchema();

        $item->setName('Add staff member to restaurant');
        $item->setRequest($request);
        $item->addResponse($response1);
        $item->addResponse($response2);

        $this->assertProperties($item, [
            'getName' => 'Add staff member to restaurant',
            'getRequest' => $request,
            'getResponse' => [$response1, $response2]
        ]);
    }

    /**
     * Test data object as array.
     *
     * @return void
     */
    public function testToArray(): void
    {
        $this->assertToObjectArray(ItemSchema::class, [
            'name' => 'Add staff member to restaurant',
            'request' => new RequestSchema(),
            'response' => [
                new ResponseSchema(),
                new ResponseSchema()
            ]
        ]);
    }
}