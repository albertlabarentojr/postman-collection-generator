<?php
declare(strict_types=1);

namespace Tests\App\DataObjects;

use App\Objects\RequestObject;
use App\Objects\ResponseObject;
use Tests\App\ObjectTestCase;

class ResponseObjectObjectTest extends ObjectTestCase
{
    /**
     * Test data object properties.
     *
     * @return void
     */
    public function testProperties(): void
    {
        $response = new ResponseObject();
        $request = new RequestObject();

        $response->setOriginalRequest($request);
        $response->setResponseTime(10);
        $response->setHeader(['Header-1']);
        $response->setBody(['param1' => 'test-value']);
        $response->setName('Successful');
        $response->setStatus('200 OK');
        $response->setCode(200);

        $this->assertProperties($response, [
            'getOriginalRequest' => $request,
            'getResponseTime' => 10,
            'getHeader' => ['Header-1'],
            'getBody' => ['param1' => 'test-value'],
            'getStatus' => '200 OK',
            'getCode' => 200,
            'getName' => 'Successful'
        ]);
    }

    /**
     * Test response id should not be generated once given.
     *
     * @return void
     */
    public function testResponseIdShouldNotBeGeneratedOnceGiven(): void
    {
        $response = new ResponseObject(['response_id' => 'unique-id']);

        self::assertEquals('unique-id', $response->getResponseId());
    }

    /**
     * Test data object as array.
     *
     * @return void
     */
    public function testToArray(): void
    {
        $request = new RequestObject();

        $data = [
            'originalRequest' => $request,
            'responseTime' => '100 sec',
            'header' => ['Header-1'],
            'body' => ['param1' => 'test-value'],
            'status' => '404 Not Found',
            'code' => 404,
            'name' => 'Restaurant Not Found',
            '_postman_previewlanguage' => 'json'
        ];

        $response = new ResponseObject($data);

        $data['body'] = \json_encode($data['body']);

        self::assertEquals($data + ['id' => $response->getResponseId()], $response->toArray());
    }
}
