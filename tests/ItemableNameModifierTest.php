<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator;

use PostmanGenerator\Http\ResponseCode;
use PostmanGenerator\Interfaces\HttpRequestMethodInterface;
use PostmanGenerator\Interfaces\HttpResponseCodeInterface;
use PostmanGenerator\ItemableNameModifier;

final class ItemableNameModifierTest extends TestCase
{
    /**
     * Providers test data based on test cases.
     *
     * @return mixed[]
     */
    private function provider(): array
    {
        $httpCode = new ResponseCode();

        return [
            [
                '/trainers',
                HttpRequestMethodInterface::METHOD_GET,
                HttpResponseCodeInterface::HTTP_OK,
                'Trainers',
                'Trainers',
                'Successful'
            ],
            [
                '/trainers/trainerId/pokemons',
                HttpRequestMethodInterface::METHOD_POST,
                HttpResponseCodeInterface::HTTP_BAD_REQUEST,
                'Trainers.Pokemons',
                'Pokemons',
                $httpCode->getMessage(ResponseCode::HTTP_BAD_REQUEST)
            ],
            [
                '/trainers/trainerId/create-baby-pokemon',
                HttpRequestMethodInterface::METHOD_POST,
                HttpResponseCodeInterface::HTTP_CREATED,
                'Trainer',
                'Create Baby Pokemon',
                $httpCode->getMessage(HttpResponseCodeInterface::HTTP_BAD_REQUEST)
            ]
        ];
    }

    /**
     * Test get names with single resource with successful response.
     *
     * @param string $url
     * @param string $method
     * @param int $statusCode
     * @param string $expectedFolder
     * @param string $expectedRequest
     * @param string $expectedExample
     *
     * @dataProvider provider
     *
     * @return void
     */
    public function testGetRequestFolderAndExampleNames(
        string $url,
        string $method,
        int $statusCode,
        string $expectedFolder,
        string $expectedRequest,
        string $expectedExample
    ): void {
        $modifier = new ItemableNameModifier($url, $method, $statusCode);

        self::assertEquals($expectedFolder, $modifier->getFolderName());
        self::assertEquals($expectedRequest, $modifier->getRequestName());
        self::assertEquals($expectedExample, $modifier->getExampleName());
    }
}
