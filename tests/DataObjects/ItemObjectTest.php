<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator\DataObjects;

use PostmanGenerator\Objects\ItemObject;
use PostmanGenerator\Objects\RequestObject;
use PostmanGenerator\Objects\ResponseObject;
use Tests\PostmanGenerator\ObjectTestCase;

class ItemObjectTest extends ObjectTestCase
{
    /**
     * Test data object properties.
     *
     * @return void
     */
    public function testProperties(): void
    {
        $item = new ItemObject();
        $request = new RequestObject();
        $response1 = new ResponseObject();
        $response2 = new ResponseObject();

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
        $this->assertToObjectArray(ItemObject::class, [
            'name' => 'Add staff member to restaurant',
            'request' => new RequestObject(),
            'response' => [
                new ResponseObject(),
                new ResponseObject()
            ]
        ]);
    }
}