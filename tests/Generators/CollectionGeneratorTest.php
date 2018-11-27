<?php
declare(strict_types=1);

namespace Tests\App\Generators;

use App\Interfaces\CollectionRequestInterface;
use Tests\App\TestCase;

class CollectionGeneratorTest extends TestCase
{
    /**
     * Test add collection request.
     *
     * @return void
     */
    public function testAddCollection(): void
    {
        $collection = new CollectionGenerator();

        $request = $collection->add('Restaurant');

        self::assertInstanceOf(CollectionRequestInterface::class, $request);
        self::assertEquals([$request], $collection->all());
    }

    /**
     * Test add collection should throw already exists exception if trying to create collection twice.
     *
     * @return void
     */
    public function testAddCollectionAlreadyExists(): void
    {
        $this->expectException(DuplicateCollectionException::class);

        $collection = new CollectionGenerator();

        $collection->add('Restaurant');
        $collection->add('Restaurant');
    }

    /**
     *
     *
     * @return void
     */
    public function testCollectionSetInfo(): void
    {

    }
}
