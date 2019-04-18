<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator\Generators;

use PostmanGenerator\CollectionGenerator;
use PostmanGenerator\Interfaces\RequestParserInterface;
use PostmanGenerator\Interfaces\ResponseParserInterface;
use PostmanGenerator\Schemas\CollectionSchema;
use PostmanGenerator\Schemas\Config\ConfigObject;
use PostmanGenerator\Schemas\DescriptionSchema;
use PostmanGenerator\Schemas\InfoSchema;
use PostmanGenerator\Schemas\RequestSchema;
use PostmanGenerator\Schemas\ResponseSchema;
use PostmanGenerator\Serializer;
use Mockery\MockInterface;
use Tests\PostmanGenerator\TestCase;

/**
 * @covers \PostmanGenerator\CollectionGenerator
 */
class CollectionGeneratorTest extends TestCase
{
    /** @var string */
    private $collectionFile = 'collection.json';

    /**
     * Test add collection request.
     *
     * @return void
     */
    public function testAddCollection(): void
    {
        $postmanCollection = new CollectionSchema();

        $collection = new CollectionGenerator($postmanCollection, new Serializer(), new ConfigObject());

        $description = new DescriptionSchema(['content' => 'content-test']);

        $collection->add('Restaurant')->setDescription($description);

        self::assertEquals([
            'info' => null,
            'auth' => null,
            'item' => [
                ['description' => 'content-test', 'item' => [], 'name' => 'Restaurant']
            ],
            'variable' => []
        ], $collection->toArray());
    }

    /**
     * Test collection generate must export json file with collection.
     *
     * @return void
     *
     * @throws \PostmanGenerator\Exceptions\MissingConfigurationKeyException
     */
    public function testCollectionGenerate(): void
    {
        /** @var \PostmanGenerator\CollectionGenerator $collection */
        [
            $collection,
            $addStaffRequest,
            $staffResponseArr,
            $addRestaurantReq,
            $responseArr
        ] = $this->getRestaurantCollection(new ConfigObject(['export_directory' => $this->collectionFile]));

        $collection->generate();

        $file = \json_decode(\file($this->collectionFile)[0], true);

        self::assertEquals(
            $this->expectedCollectionArray(
                $addStaffRequest,
                $staffResponseArr,
                $addRestaurantReq,
                $responseArr,
                ['info' => $collection->getCollection()->getInfo()->toArray()]
            ),
            $file
        );

    }

    /**
     * Test collection with collection item and example.
     *
     * @return void
     */
    public function testCollectionToArray(): void
    {
        /** @var \PostmanGenerator\CollectionGenerator $collection */
        [
            $collection,
            $addStaffRequest,
            $staffResponseArr,
            $addRestaurantReq,
            $responseArr
        ] = $this->getRestaurantCollection(new ConfigObject());

        self::assertEquals(
            $this->expectedCollectionArray(
                $addStaffRequest,
                $staffResponseArr,
                $addRestaurantReq,
                $responseArr,
                ['info' => $collection->getCollection()->getInfo()->toArray()]
            ),
            $collection->toArray()
        );
    }

    /**
     * Run after each test.
     *
     * @return void
     */
    protected function tearDown(): void
    {
        if (\file_exists($this->collectionFile) === true) {
            \unlink($this->collectionFile);
        }
    }

    /**
     * Create full request with example.
     *
     * @param string $requestName
     * @param string $exampleName
     * @param mixed $collectionRequest
     * @param null|\PostmanGenerator\Schemas\RequestSchema $request
     * @param null|\PostmanGenerator\Schemas\ResponseSchema $response
     *
     * @return mixed[]
     */
    private function createFullRequest(
        string $requestName,
        string $exampleName,
        $collectionRequest,
        ?RequestSchema $request = null,
        ?ResponseSchema $response = null
    ): array {
        $request = $request ?? new RequestSchema();
        $response = $response ?? new ResponseSchema();

        /** @var \PostmanGenerator\Interfaces\RequestParserInterface $requestParser */
        /** @var \PostmanGenerator\Interfaces\ResponseParserInterface $responseParser */
        [$requestParser, $responseParser] = $this->getParsers($request, $response);

        /** @var \PostmanGenerator\Interfaces\RequestExampleInterface $collection */
        $collection = $collectionRequest->addRequest($requestName, $requestParser);
        $collection->addExample($exampleName, $requestParser, $responseParser);

        $responseArr = $response->toArray();

        /** @var \PostmanGenerator\Schemas\RequestSchema $requestArr */
        $requestArr = $responseArr['originalRequest'];

        $responseArr['originalRequest'] = $requestArr->toArray();

        return [$request, $responseArr, $response];
    }

    /**
     * Get expected data of collection as array.
     *
     * @param \PostmanGenerator\Schemas\RequestSchema $addStaffRequest
     * @param mixed[] $staffResponseArr
     * @param \PostmanGenerator\Schemas\RequestSchema $addRestaurantReq
     * @param mixed[] $responseArr
     * @param null|mixed[] $additionalConfig
     *
     * @return mixed[]
     */
    private function expectedCollectionArray(
        RequestSchema $addStaffRequest,
        array $staffResponseArr,
        RequestSchema $addRestaurantReq,
        array $responseArr,
        ?array $additionalConfig = null
    ): array {
        $expectedData = [
            'info' => null,
            'auth' => null,
            'item' => [
                [
                    'name' => 'Restaurant',
                    'item' => [
                        [
                            'name' => 'Staff member',
                            'item' => [
                                [
                                    'name' => 'Add staff member to restaurant',
                                    'request' => $addStaffRequest->toArray(),
                                    'response' => [['name' => 'Create Successful'] + $staffResponseArr]
                                ]
                            ],
                            '_postman_isSubFolder' => true
                        ],
                        [
                            'name' => 'Create Restaurant',
                            'request' => $addRestaurantReq->toArray(),
                            'response' => [['name' => 'Create Restaurant Successful'] + $responseArr]
                        ]
                    ],
                    'description' => ['content' => 'test-description', 'type' => DescriptionSchema::DEFAULT_TYPE]
                ]
            ],
            'variable' => []
        ];

        if ($additionalConfig === null) {
            return $expectedData;
        }

        return \array_merge($expectedData, $additionalConfig);
    }

    /**
     * Get request and response parser.
     *
     * @param null|\PostmanGenerator\Schemas\RequestSchema $request
     * @param null|\PostmanGenerator\Schemas\ResponseSchema $response
     *
     * @return mixed[]
     */
    private function getParsers(
        ?RequestSchema $request = null,
        ?ResponseSchema $response = null
    ): array {
        $request = $request ?? new RequestSchema();

        $response = $response ?? new ResponseSchema();

        /** @var \PostmanGenerator\Interfaces\RequestParserInterface $requestParser */
        $requestParser = $this->mock(
            RequestParserInterface::class,
            function (MockInterface $mock) use ($request): void {
                $mock->shouldReceive('parseRequest')->once()->withNoArgs()->andReturn($request);
            }
        );

        /** @var \PostmanGenerator\Interfaces\ResponseParserInterface $responseParser */
        $responseParser = $this->mock(
            ResponseParserInterface::class,
            function (MockInterface $mock) use ($response): void {
                $mock->shouldReceive('parseResponse')->once()->withNoArgs()->andReturn($response);
            }
        );

        return [$requestParser, $responseParser];
    }

    /**
     * Get restaurant collection with configs.
     *
     * @param \PostmanGenerator\Schemas\Config\ConfigObject $configObject
     *
     * @return array
     */
    private function getRestaurantCollection(ConfigObject $configObject): array
    {
        $info = new InfoSchema([
            'name' => 'edining v2',
            'description' => 'Description as string',
            'schema' => 'https://schema.getpostman.com/json/collection/v2.1.0/collection.json'
        ]);

        $postmanCollection = new CollectionSchema(\compact('info'));

        $collection = new CollectionGenerator($postmanCollection, new Serializer(), $configObject);

        $description = new DescriptionSchema(['content' => 'test-description']);

        $restaurant = $collection->add('Restaurant');

        $staffMember = $restaurant->addSubCollection('Staff member');

        $restaurant->addConfig(['description' => $description]);

        [$addStaffRequest, $staffResponseArr] = $this->createFullRequest(
            'Add staff member to restaurant',
            'Create Successful',
            $staffMember
        );

        [$addRestaurantReq, $responseArr] = $this->createFullRequest(
            'Create Restaurant',
            'Create Restaurant Successful',
            $restaurant
        );

        return [$collection, $addStaffRequest, $staffResponseArr, $addRestaurantReq, $responseArr];
    }
}
