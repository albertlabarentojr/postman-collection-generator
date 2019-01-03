<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator;

use PostmanGenerator\Interfaces\CollectionObjectInterface;

abstract class ObjectTestCase extends TestCase
{
    /**
     * Test data object properties.
     *
     * @return void
     */
    abstract public function testProperties(): void;

    /**
     * Test data object as array.
     *
     * @return void
     */
    abstract public function testToArray(): void;

    /**
     * Assert object properties.
     *
     * @return void
     *
     * @param \PostmanGenerator\Interfaces\CollectionObjectInterface $collectionObject
     * @param array $methodMappings
     */
    protected function assertProperties(CollectionObjectInterface $collectionObject, array $methodMappings): void
    {
        foreach ($methodMappings as $method => $expected) {
            $actual = $collectionObject->{$method}();

            if (\is_object($actual) && \is_object($expected)) {
                $actual = \spl_object_hash($actual);
                $expected = \spl_object_hash($expected);
            }

            self::assertEquals($expected, $actual);
        }
    }

    /**
     * Assert object to array.
     *
     * @return void
     *
     * @param string $objectClass
     * @param  mixed[] $data
     */
    protected function assertToObjectArray(string $objectClass, array $data): void
    {
        /** @var \PostmanGenerator\Interfaces\CollectionObjectInterface $object */
        $object = new $objectClass($data);

        self::assertEquals($data, $object->toArray());
    }
}
