<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator\Generators;

use PostmanGenerator\CollectionGenerator;
use PostmanGenerator\Config;
use PostmanGenerator\Interfaces\ConfigInterface;
use PostmanGenerator\Interfaces\RequestParserInterface;
use PostmanGenerator\Interfaces\ResponseParserInterface;
use PostmanGenerator\Schemas\CollectionSchema;
use PostmanGenerator\Schemas\DescriptionSchema;
use PostmanGenerator\Schemas\InfoSchema;
use PostmanGenerator\Schemas\RequestSchema;
use PostmanGenerator\Schemas\ResponseSchema;
use Mockery\MockInterface;
use Tests\PostmanGenerator\TestCase;

/**
 * @covers \PostmanGenerator\CollectionGenerator
 */
class CollectionGeneratorTest extends TestCase
{
    /** @var string  */
    private $collectionDir = __DIR__;

    /** @var string */
    private $collectionFile = 'collection';

    /**
     * Test add collection request.
     *
     * @return void
     */
    public function testAddCollection(): void
    {
        $postmanCollection = new CollectionSchema();

        $collection = new CollectionGenerator($postmanCollection);
        $collection->setConfig(new Config($this->collectionDir, $this->collectionFile));

        $description = new DescriptionSchema(['content' => 'content-test']);

        $collection->add('Restaurant')->setDescription($description);
        $collection->generate();

        $filepath = \sprintf('%s/%s.json', $this->collectionDir, $this->collectionFile);

        $this->assertGeneratedCollection($filepath, [
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
        ] = $this->getRestaurantCollection(new Config($this->collectionDir, $this->collectionFile));

        $collection->generate();

        $file = \json_decode(\file($this->collectionDir . '/' . $this->collectionFile . '.json')[0], true);

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
        ] = $this->getRestaurantCollection(new Config());

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
     * @param null|\PostmanGenerator\Objects\RequestSchema $request
     * @param null|\PostmanGenerator\Objects\ResponseSchema $response
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

        /** @var \PostmanGenerator\Objects\RequestSchema $requestArr */
        $requestArr = $responseArr['originalRequest'];

        $responseArr['originalRequest'] = $requestArr->toArray();

        return [$request, $responseArr, $response];
    }

    /**
     * Get expected data of collection as array.
     *
     * @param \PostmanGenerator\Objects\RequestSchema $addStaffRequest
     * @param mixed[] $staffResponseArr
     * @param \PostmanGenerator\Objects\RequestSchema $addRestaurantReq
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
     * @param null|\PostmanGenerator\Objects\RequestSchema $request
     * @param null|\PostmanGenerator\Objects\ResponseSchema $response
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
     * @param \PostmanGenerator\Interfaces\ConfigInterface $config
     *
     * @return array
     */
    private function getRestaurantCollection(ConfigInterface $config): array
    {
        $info = new InfoSchema([
            'name' => 'edining v2',
            'description' => 'Description as string',
            'schema' => 'https://schema.getpostman.com/json/collection/v2.1.0/collection.json'
        ]);

        $postmanCollection = new CollectionSchema(\compact('info'));

        $collection = new CollectionGenerator($postmanCollection);
        $collection->setConfig($config);

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
