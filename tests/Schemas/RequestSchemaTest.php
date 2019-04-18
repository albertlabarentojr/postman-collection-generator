<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator\Schemas;

use PostmanGenerator\Exceptions\InvalidRequestMethodException;
use PostmanGenerator\Schemas\AuthSchema;
use PostmanGenerator\Schemas\DescriptionSchema;
use PostmanGenerator\Schemas\HeaderSchema;
use PostmanGenerator\Schemas\RequestBodySchema;
use PostmanGenerator\Schemas\RequestSchema;
use PostmanGenerator\Schemas\UrlSchema;
use Tests\PostmanGenerator\SchemaTestCase;

/**
 * @covers \PostmanGenerator\Schemas\RequestSchema
 */
class RequestSchemaTest extends SchemaTestCase
{
    /**
     * Test data object properties.
     *
     * @return void
     *
     * @throws \PostmanGenerator\Exceptions\InvalidRequestMethodException
     */
    public function testProperties(): void
    {
        $request = new RequestSchema();

        $url = new UrlSchema();
        $description = new DescriptionSchema();
        $header = new HeaderSchema();
        $body = new RequestBodySchema();
        $auth = new AuthSchema();

        $request->setUrl($url);
        $request->setAuth($auth);
        $request->setMethod('GET');
        $request->setDescription($description);
        $request->setHeader($header);
        $request->setBody($body);

        $this->assertProperties($request, [
            'getUrl' => $url,
            'getAuth' => $auth,
            'getMethod' => 'GET',
            'getDescription' => $description,
            'getHeader' => $header,
            'getBody' => $body
        ]);
    }

    /**
     * Test data object as array.
     *
     * @return void
     */
    public function testToArray(): void
    {
        $url = new UrlSchema();
        $description = new DescriptionSchema();
        $header = new HeaderSchema();
        $body = new RequestBodySchema();
        $auth = new AuthSchema();

        $this->assertToObjectArray(RequestSchema::class, [
            'auth' => $auth,
            'description' => $description,
            'header' => $header,
            'url' => $url,
            'method' => 'GET',
            'body' => $body
        ]);
    }

    /**
     * Test set method should throw InvalidRequestMethodException when trying to add invalid method type.
     *
     * @return void
     */
    public function testSetMethodInvalidType(): void
    {
        $this->expectException(InvalidRequestMethodException::class);

        new RequestSchema(['method' => 'invalid-method']);
    }
}
