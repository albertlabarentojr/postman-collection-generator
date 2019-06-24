<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator\Schemas;

use PostmanGenerator\Schemas\RequestSchema;
use PostmanGenerator\Schemas\ResponseSchema;
use Tests\PostmanGenerator\SchemaTestCase;

class ResponseSchemaTest extends SchemaTestCase
{
    /**
     * Test data object properties.
     *
     * @return void
     */
    public function testProperties(): void
    {
        $response = new ResponseSchema();
        $request = new RequestSchema();

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
        $response = new ResponseSchema(['response_id' => 'unique-id']);

        self::assertEquals('unique-id', $response->getResponseId());
    }

    /**
     * Test data object as array.
     *
     * @return void
     */
    public function testToArray(): void
    {
        $request = new RequestSchema();

        $data = [
            'originalRequest' => $request,
            'responseTime' => '100 sec',
            'header' => ['Header-1'],
            'body' => ['param1' => 'test-value'],
            'status' => '404 Not Found',
            'code' => 404,
            'name' => 'Restaurant Not Found',
            '_postman_previewlanguage' => 'text'
        ];

        $response = new ResponseSchema($data);

        self::assertEquals($data + ['id' => $response->getResponseId()], $response->toArray());
    }
}
