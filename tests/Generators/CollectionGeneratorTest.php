<?php
declare(strict_types=1);

namespace Tests\App\Generators;

use App\CollectionGenerator;
use App\Interfaces\RequestParserInterface;
use App\Interfaces\ResponseParserInterface;
use App\Objects\CollectionObject;
use App\Objects\DescriptionObject;
use App\Objects\RequestObject;
use App\Objects\ResponseObject;
use App\Serializer;
use Mockery\MockInterface;
use Tests\App\TestCase;

/**
 * @covers \App\CollectionGenerator
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
        $postmanCollection = new CollectionObject();

        $collection = new CollectionGenerator($postmanCollection, new Serializer());

        $description = new DescriptionObject(['content' => 'content-test']);

        $collection->add('Restaurant')->setDescription($description);

        self::assertEquals([
            'info' => null,
            'auth' => null,
            'item' => [
                ['description' => 'content-test', 'item' => [], 'name' => 'Restaurant']
            ],
            'variable' => []
        ], $collection->all());
    }

    /**
     * Test collection with collection item and example.
     *
     * @return void
     */
    public function testAddCollectionRequest(): void
    {
        $postmanCollection = new CollectionObject();

        $collection = new CollectionGenerator($postmanCollection, new Serializer());

        $description = new DescriptionObject(['content' => 'test-description']);

        $restaurant = $collection->add('Restaurant');

        $staffMemeber = $restaurant->addSubCollection('Staff member');

        $restaurant->addConfig(['description' => $description]);

        $staffRequest = new RequestObject();
        $staffResponse = new ResponseObject();

        /** @var \App\Interfaces\RequestParserInterface $staffRequestParser */
        /** @var \App\Interfaces\ResponseParserInterface $staffResponseParser */
        [$staffRequestParser, $staffResponseParser] = $this->getParsers($staffRequest, $staffResponse);

        $attachStaffMember = $staffMemeber->addRequest('Attach Staff member', $staffRequestParser);
        $attachStaffMember->addExample('Attach Successful', $staffRequestParser, $staffResponseParser);

        $staffResponseArr = $staffResponse->toArray();

        /** @var \App\Objects\RequestObject $staffOrgRequest */
        $staffOrgRequest = $staffResponseArr['originalRequest'];

        $staffResponseArr['originalRequest'] = $staffOrgRequest->toArray();

        $request = new RequestObject();
        $response = new ResponseObject();

        /** @var \App\Interfaces\RequestParserInterface $requestParser */
        /** @var \App\Interfaces\ResponseParserInterface $responseParser */
        [$requestParser, $responseParser] = $this->getParsers($request, $response);

        $requestExample = $restaurant->addRequest('Create Restaurant', $requestParser);
        $requestExample->addExample('Create Restaurant Successful', $requestParser, $responseParser);

        $responseArr = $response->toArray();

        /** @var \App\Objects\RequestObject $originalRequest */
        $originalRequest = $responseArr['originalRequest'];

        $responseArr['originalRequest'] = $originalRequest->toArray();

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
                                    'name' => 'Attach Staff member',
                                    'request' => $staffRequest->toArray(),
                                    'response' => [['name' => 'Attach Successful'] + $staffResponseArr]
                                ]
                            ],
                            '_postman_isSubFolder' => true
                        ],
                        [
                            'name' => 'Create Restaurant',
                            'request' => $request->toArray(),
                            'response' => [['name' => 'Create Restaurant Successful'] + $responseArr]
                        ]
                    ],
                    'description' => ['content' => 'test-description', 'type' => DescriptionObject::DEFAULT_TYPE]
                ]
            ],
            'variable' => []
        ];

        self::assertEquals($expectedData, $collection->all());
    }

    /**
     * Get request and response parser.
     *
     * @param null|\App\Objects\RequestObject $request
     * @param null|\App\Objects\ResponseObject $response
     *
     * @return mixed[]
     */
    private function getParsers(
        ?RequestObject $request = null,
        ?ResponseObject $response = null
    ): array {
        $request = $request ?? new RequestObject();

        $response = $response ?? new ResponseObject();

        /** @var \App\Interfaces\RequestParserInterface $requestParser */
        $requestParser = $this->mock(
            RequestParserInterface::class,
            function (MockInterface $mock) use ($request): void {
                $mock->shouldReceive('parseRequest')->once()->withNoArgs()->andReturn($request);
            }
        );

        /** @var \App\Interfaces\ResponseParserInterface $responseParser */
        $responseParser = $this->mock(
            ResponseParserInterface::class,
            function (MockInterface $mock) use ($response): void {
                $mock->shouldReceive('parseResponse')->once()->withNoArgs()->andReturn($response);
            }
        );

        return [$requestParser, $responseParser];
    }
}
