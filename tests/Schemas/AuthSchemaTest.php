<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator\Schemas;

use PostmanGenerator\Exceptions\InvalidAuthTypeException;
use PostmanGenerator\Schemas\AuthSchema;
use Tests\PostmanGenerator\SchemaTestCase;

/**
 * @covers \PostmanGenerator\Schemas\AuthSchema
 */
class AuthSchemaTest extends SchemaTestCase
{
    /**
     * Test data object properties.
     *
     * @return void
     *
     * @throws \PostmanGenerator\Exceptions\InvalidAuthTypeException
     */
    public function testProperties(): void
    {
        $auth = new AuthSchema();

        $auth->setType('awsv4');
        $auth->setConfig(['aws-key' => 'key-test']);

        self::assertEquals('awsv4', $auth->getType());
        self::assertEquals(['aws-key' => 'key-test'], $auth->getConfig());
    }

    /**
     * Test set type as argument should throw InvalidAuthTypeException.
     *
     * @return void
     */
    public function testSetTypeAsArgumentThrowsInvalidAuthTypeException(): void
    {
        $this->expectException(InvalidAuthTypeException::class);

        new AuthSchema(['type' => 'invalid-type']);
    }

    /**
     * Test set type should throw InvalidAuthTypeException.
     *
     * @return void
     *
     * @throws \PostmanGenerator\Exceptions\InvalidAuthTypeException
     */
    public function testSetTypeThrowsInvalidAuthTypeException(): void
    {
        $this->expectException(InvalidAuthTypeException::class);

        (new AuthSchema())->setType('invalid-type');
    }

    /**
     * Test data object as array.
     *
     * @return void
     *
     * @throws \PostmanGenerator\Exceptions\InvalidAuthTypeException
     */
    public function testToArray(): void
    {
        $auth = new AuthSchema();

        $auth->setType('awsv4');
        $auth->setConfig(['aws-key' => 'key-test']);

        self::assertEquals([
            'awsv4' => ['aws-key' => 'key-test'],
            'type' => 'awsv4'
        ], $auth->toArray());
    }
}
