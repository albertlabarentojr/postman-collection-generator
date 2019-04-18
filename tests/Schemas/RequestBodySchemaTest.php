<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator\Schemas;

use PostmanGenerator\Exceptions\InvalidModeTypeException;
use PostmanGenerator\Schemas\FileSchema;
use PostmanGenerator\Schemas\FormParameterSchema;
use PostmanGenerator\Schemas\RequestBodySchema;
use PostmanGenerator\Schemas\UrlSchema;
use Tests\PostmanGenerator\SchemaTestCase;

/**
 * @covers \PostmanGenerator\Schemas\RequestBodySchema
 */
class RequestBodySchemaTest extends SchemaTestCase
{
    /**
     * Test mode should throw InvalidModeTypeException when trying to add invalid mode type.
     *
     * @return void
     */
    public function testModeThrowsInvalidType(): void
    {
        $this->expectException(InvalidModeTypeException::class);

        new RequestBodySchema(['mode' => 'invalid-mode']);
    }

    /**
     * Test data object properties.
     *
     * @return void
     *
     * @throws \PostmanGenerator\Exceptions\InvalidModeTypeException
     */
    public function testProperties(): void
    {
        $body = new RequestBodySchema();

        $url = new UrlSchema();
        $formParameter = new FormParameterSchema();
        $file = new FileSchema();

        $body->setDisabled(false);
        $body->setMode('file');
        $body->setRaw('test-raw');
        $body->setUrl($url);
        $body->setFormParameter($formParameter);
        $body->setFile($file);

        $this->assertProperties($body, [
            'isDisabled' => false,
            'getMode' => 'file',
            'getRaw' => 'test-raw',
            'getUrl' => $url,
            'getFormParameter' => $formParameter,
            'getFile' => $file
        ]);
    }

    /**
     * Test data object as array.
     *
     * @return void
     */
    public function testToArray(): void
    {
        $file = new FileSchema();
        $url = new UrlSchema();
        $formParameter = new FormParameterSchema();

        $body = new RequestBodySchema([
            'disabled' => false,
            'file' => $file,
            'form_parameter' => $formParameter,
            'mode' => 'file',
            'raw' => 'test-raw',
            'url' => $url
        ]);

        self::assertEquals([
            'disabled' => false,
            'file' => $file,
            'formdata' => $formParameter,
            'mode' => 'file',
            'raw' => 'test-raw',
            'urlencoded' => $url
        ], $body->toArray());
    }
}
