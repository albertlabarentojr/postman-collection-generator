<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator;

use PostmanGenerator\CollectionGenerator;
use PostmanGenerator\Config;
use PostmanGenerator\Schemas\CollectionSchema;
use PostmanGenerator\Schemas\DescriptionSchema;
use PostmanGenerator\Serializer;
use Tests\PostmanGenerator\Stubs\RequestParserStub;

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

        $collection = new CollectionGenerator(
            $postmanCollection,
            new Config($this->collectionDir, $this->collectionFile)
        );

        $description = new DescriptionSchema(['content' => 'content-test']);

        $collection->add('Restaurant', \compact('description'));
        $collection->generate();

        $this->assertGeneratedCollection($this->collectionDir, $this->collectionFile, [
            'info' => null,
            'auth' => null,
            'item' => [
                ['description' => $description->toArray(), 'item' => [], 'name' => 'Restaurant']
            ],
            'variable' => []
        ]);
    }

    /**
     * Test add collection should support nested sub collections.
     *
     * @return void
     */
    public function testAddCollectionNestedSubCollection(): void
    {
        $postmanCollection = new CollectionSchema();

        // First instance
        $collection = new CollectionGenerator(
            $postmanCollection,
            new Config($this->collectionDir, $this->collectionFile)
        );

        $description = new DescriptionSchema(['content' => 'content-test']);

        $collection->add('Trainers.Laboratories', ['description' => $description]);
        $collection->add('Trainers.Inventory.Pokeballs');
        $pokemons = $collection->add('Trainers.Pokemons');

        $request = new RequestParserStub([]);

        $createPokemon = $pokemons->addRequest('Create Pokemon', $request);

        $response1 = $this->getResponseParserInstance([
            'name' => 'Create Successful',
            'responseId' => 'id',
            'originalRequest' => $request->parse()
        ]);
        $createPokemon->addExample('Create Successful', $request, $response1);

        $collection->generate();

        // Second Instance
        $collection2 = new CollectionGenerator(
            $postmanCollection,
            new Config($this->collectionDir, $this->collectionFile)
        );

        $description2 = new DescriptionSchema(['content' => 'content-test']);

        $collection2->add('Trainers.Laboratories', ['description' => $description2]);
        $collection2->add('Trainers.Inventory.Pokeballs');
        $pokemons2 = $collection2->add('Trainers.Pokemons');

        $response2 = $this->getResponseParserInstance([
            'name' => 'Not Found',
            'responseId' => 'id',
            'originalRequest' => $request->parse()
        ]);

        $createPokemon2 = $pokemons2->addRequest('Create Pokemon', $request);
        $createPokemon2->addExample('Not Found', $request, $response2);

        $collection2->generate();

        $this->assertGeneratedCollection($this->collectionDir, $this->collectionFile, [
            'info' => null,
            'auth' => null,
            'item' => [
                [
                    'description' => $description2->toArray(),
                    'item' => [
                        ['name' => 'Laboratories', 'item' => [], '_postman_isSubFolder' => true],
                        [
                            'name' => 'Inventory',
                            'item' => [['name' => 'Pokeballs', 'item' => [], '_postman_isSubFolder' => true]],
                            '_postman_isSubFolder' => true
                        ],
                        [
                            'name' => 'Pokemons',
                            'item' => [
                                [
                                    'name' => 'Create Pokemon',
                                    'request' => (new RequestParserStub([]))->parse()->toArray(),
                                    'response' => [
                                        (new Serializer())->serialize($response1->parse()),
                                        (new Serializer())->serialize($response2->parse())
                                    ]
                                ]
                            ],
                            '_postman_isSubFolder' => true
                        ]
                    ],
                    'name' => 'Trainers'
                ]
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

        $file = \json_decode(\file_get_contents($this->collectionDir . '/' . $this->collectionFile . '.json'), true);

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
