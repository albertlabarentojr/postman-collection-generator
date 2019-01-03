<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator\DataObjects;

use PostmanGenerator\Exceptions\InvalidRequestMethodException;
use PostmanGenerator\Objects\AuthObject;
use PostmanGenerator\Objects\DescriptionObject;
use PostmanGenerator\Objects\HeaderObject;
use PostmanGenerator\Objects\RequestBodyObject;
use PostmanGenerator\Objects\RequestObject;
use PostmanGenerator\Objects\UrlObject;
use Tests\PostmanGenerator\ObjectTestCase;

/**
 * @covers \PostmanGenerator\Objects\RequestObject
 */
class RequestObjectObjectTest extends ObjectTestCase
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
        $request = new RequestObject();

        $url = new UrlObject();
        $description = new DescriptionObject();
        $header = new HeaderObject();
        $body = new RequestBodyObject();
        $auth = new AuthObject();

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
        $url = new UrlObject();
        $description = new DescriptionObject();
        $header = new HeaderObject();
        $body = new RequestBodyObject();
        $auth = new AuthObject();

        $this->assertToObjectArray(RequestObject::class, [
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

        new RequestObject(['method' => 'invalid-method']);
    }
}
