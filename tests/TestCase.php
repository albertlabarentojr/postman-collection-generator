<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator;

use Closure;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase as PhpunitTestCase;
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

abstract class TestCase extends PhpunitTestCase
{
    /** @var string */
    protected $cachedCollectionFile = 'collection-cached';

    /** @var string */
    protected $collectionDir = __DIR__;

    /** @var string */
    protected $collectionFile = 'collection';

    /**
     * Create mock with callback.
     *
     * @param string $mockClass
     * @param \Closure|null $callback
     *
     * @return \Mockery\MockInterface
     */
    public function mock(string $mockClass, ?Closure $callback = null): MockInterface
    {
        $mock = Mockery::mock($mockClass);

        if ($callback !== null) {
            $callback($mock);
        }

        return $mock;
    }

    /**
     * Assert given file contains expected collection content.
     *
     * @param string $directory
     * @param string $file
     * @param array $expected
     *
     * @return void
     */
    protected function assertGeneratedCollection(string $directory, string $file, array $expected): void
    {
        $filepath = \sprintf('%s/%s.json', $directory, $file);

        self::assertEquals($expected, \json_decode(\file_get_contents($filepath), true));
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
    protected function createFullRequest(
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
    protected function expectedCollectionArray(
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
     * Get collection generator.
     *
     * @param \PostmanGenerator\Interfaces\ConfigInterface $config
     *
     * @return \PostmanGenerator\CollectionGenerator
     */
    protected function getCollectionGenerator(?ConfigInterface $config = null): CollectionGenerator
    {
        $info = new InfoSchema([
            'name' => 'edining v2',
            'description' => 'Description as string',
            'schema' => 'https://schema.getpostman.com/json/collection/v2.1.0/collection.json'
        ]);

        $postmanCollection = new CollectionSchema(\compact('info'));

        $collection = new CollectionGenerator(
            $postmanCollection,
            $config ?? new Config($this->collectionDir, $this->collectionFile)
        );

        return $collection;
    }

    /**
     * Get request and response parser.
     *
     * @param null|\PostmanGenerator\Schemas\RequestSchema $request
     * @param null|\PostmanGenerator\Schemas\ResponseSchema $response
     *
     * @return mixed[]
     */
    protected function getParsers(
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
    protected function getRestaurantCollection(?ConfigInterface $config = null): array
    {
        $collection = $this->getCollectionGenerator($config);

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

    /**
     * Run after each test.
     *
     * @return void
     */
    protected function tearDown(): void
    {
        $collectionPath = \sprintf('%s/%s.json', $this->collectionDir, $this->collectionFile);
        $cachedPath = \sprintf('%s/%s', $this->collectionDir, $this->cachedCollectionFile);

        if (\file_exists($collectionPath) === true) {
            \unlink($collectionPath);
        }

        if (\file_exists($cachedPath) === true) {
            \unlink($cachedPath);
        }
    }
}
