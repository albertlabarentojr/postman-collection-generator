<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator\DataObjects;

use PostmanGenerator\Exceptions\InvalidAuthTypeException;
use PostmanGenerator\Objects\AuthObject;
use Tests\PostmanGenerator\ObjectTestCase;

/**
 * @covers \PostmanGenerator\Objects\AuthObject
 */
class AuthObjectObjectTest extends ObjectTestCase
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
        $auth = new AuthObject();

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

        new AuthObject(['type' => 'invalid-type']);
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

        (new AuthObject())->setType('invalid-type');
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
        $auth = new AuthObject();

        $auth->setType('awsv4');
        $auth->setConfig(['aws-key' => 'key-test']);

        self::assertEquals([
            'awsv4' => ['aws-key' => 'key-test'],
            'type' => 'awsv4'
        ], $auth->toArray());
    }
}
