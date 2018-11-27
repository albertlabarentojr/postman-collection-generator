<?php
declare(strict_types=1);

namespace Tests\App\DataObjects;

use App\Exceptions\InvalidRequestMethodException;
use App\Objects\AuthObject;
use App\Objects\DescriptionObject;
use App\Objects\HeaderObject;
use App\Objects\RequestBodyObject;
use App\Objects\RequestObject;
use App\Objects\UrlObject;
use Tests\App\ObjectTestCase;

/**
 * @covers \App\Objects\RequestObject
 */
class RequestObjectObjectTest extends ObjectTestCase
{
    /**
     * Test data object properties.
     *
     * @return void
     *
     * @throws \App\Exceptions\InvalidRequestMethodException
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
