<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator\DataObjects;

use PostmanGenerator\Exceptions\InvalidMethodCallException;
use Tests\PostmanGenerator\ObjectTestCase;

/**
 * @covers \PostmanGenerator\Objects\AbstractDataObject
 */
class AbstractDataObjectObjectTest extends ObjectTestCase
{
    /**
     * Test data array to fill properties.
     *
     * @return void
     */
    public function testDataFill(): void
    {
        $dto = new DataObjectStub(['dataAsString' => 'this is a string', 'dataAsInt' => 1, 'dataBol' => true]);

        self::assertEquals('this is a string', $dto->getDataAsString());
        self::assertEquals(1, $dto->getDataAsInt());
        self::assertTrue($dto->isDataBol());
    }

    public function testPrePopulateObject(): void
    {
        $dto = new PrePopulateObjectStub();

        self::assertNotEmpty($dto->getObjectId());
    }

    /**
     * Test data object properties.
     *
     * @return void
     */
    public function testProperties(): void
    {
        $dto = new DataObjectStub();

        $dto->setDataBol(false);
        $dto->setDataAsInt(10);
        $dto->setDataAsString('i-am-a-string');

        $this->assertProperties($dto, [
            'isDataBol' => false,
            'getDataAsInt' => 10,
            'getDataAsString' => 'i-am-a-string'
        ]);
    }

    /**
     * Test data object must throw InvalidMethodCallException when property not found.
     *
     * @return void
     */
    public function testPropertyNotFound(): void
    {
        $this->expectException(InvalidMethodCallException::class);

        $dto = new DataObjectStub([]);
        $dto->getDummyProp();
    }

    /**
     * Test string `setter` and `getter` methods.
     *
     * @return void
     */
    public function testPropertyString(): void
    {
        $dto = new DataObjectStub([]);
        $dto->setDataAsString('this is a string');

        self::assertEquals('this is a string', $dto->getDataAsString());
    }

    /**
     * Snake case as property must be acceptable for mass assignment.
     *
     * @return void
     */
    public function testSnakeCaseMassAssignment(): void
    {
        $dto = new DataObjectStub(['another_property' => 'this is a property']);

        self::assertEquals('this is a property', $dto->getAnotherProperty());
    }

    /**
     * Test data object as array.
     *
     * @return void
     */
    public function testToArray(): void
    {
        $dto = new DataObjectStub(['dataAsString' => 'this is a string', 'dataAsInt' => 1, 'dataBol' => true]);

        self::assertEquals([
            'int' => 1,
            'string' => 'this is a string',
            'bol' => true
        ], $dto->toArray());
    }
}
