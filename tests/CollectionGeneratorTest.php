<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator;

use PostmanGenerator\CollectionGenerator;
use PostmanGenerator\Config;
use PostmanGenerator\Schemas\CollectionSchema;
use PostmanGenerator\Schemas\DescriptionSchema;
use PostmanGenerator\Serializer;

/**
 * @covers \PostmanGenerator\CollectionGenerator
 */
class CollectionGeneratorTest extends TestCase
{
    /**
     * Test add collection request.
     *
     * @return void
     */
    public function testAddCollection(): void
    {
        $postmanCollection = new CollectionSchema();

        $collection = new CollectionGenerator($postmanCollection, new Config($this->collectionDir,
            $this->collectionFile));

        $description = new DescriptionSchema(['content' => 'content-test']);

        $collection->add('Restaurant')->setDescription($description);
        $collection->generate();

        $this->assertGeneratedCollection($this->collectionDir, $this->collectionFile, [
            'info' => null,
            'auth' => null,
            'item' => [
                ['description' => 'content-test', 'item' => [], 'name' => 'Restaurant']
            ],
            'variable' => []
        ]);
    }

    /**
     * Test collection generate must export json file with collection.
     *
     * @return void
     */
    public function testCollectionGenerate(): void
    {
        /** @var \PostmanGenerator\CollectionGenerator $collectionGenerator */
        [
            $collectionGenerator,
            $addStaffRequest,
            $staffResponseArr,
            $addRestaurantReq,
            $responseArr
        ] = $this->getRestaurantCollection(new Config($this->collectionDir, $this->collectionFile));

        $collectionGenerator->generate();

        $file = \json_decode(\file($this->collectionDir . '/' . $this->collectionFile . '.json')[0], true);

        self::assertEquals(
            $this->expectedCollectionArray(
                $addStaffRequest,
                $staffResponseArr,
                $addRestaurantReq,
                $responseArr,
                ['info' => $collectionGenerator->getCollection()->getInfo()->toArray()]
            ),
            $file
        );
    }

    /**
     * Test collection generator must also generate a cached file.
     *
     * @return void
     */
    public function testCollectionMustGenerateCache(): void
    {
        $collectionGenerator1 = $this->getCollectionGenerator(new Config($this->collectionDir, $this->collectionFile));
        $collectionGenerator1->generate();

        $cachedFilePath = \sprintf('%s/%s', $this->collectionDir, $this->cachedCollectionFile);

        self::assertFileExists($cachedFilePath);

        $collectionGenerator2 = $this->getCollectionGenerator(new Config($this->collectionDir, $this->collectionFile));

        $serializer = new Serializer();

        self::assertEquals(
            $serializer->serialize($collectionGenerator2->getCollection()),
            $serializer->serialize(\unserialize(\file_get_contents($cachedFilePath)))
        );
    }

    /**
     * Test collection with collection item and example.
     *
     * @return void
     */
    public function testCollectionToArray(): void
    {
        /** @var \PostmanGenerator\CollectionGenerator $collectionGenerator */
        [
            $collectionGenerator,
            $addStaffRequest,
            $staffResponseArr,
            $addRestaurantReq,
            $responseArr
        ] = $this->getRestaurantCollection(new Config($this->collectionDir, $this->collectionFile));

        self::assertEquals(
            $this->expectedCollectionArray(
                $addStaffRequest,
                $staffResponseArr,
                $addRestaurantReq,
                $responseArr,
                ['info' => $collectionGenerator->getCollection()->getInfo()->toArray()]
            ),
            $collectionGenerator->toArray()
        );
    }
}
