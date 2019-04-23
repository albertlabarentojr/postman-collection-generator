<?php
declare(strict_types=1);

namespace PostmanGenerator\Traits;

use PostmanGenerator\CollectionGenerator;
use PostmanGenerator\Interfaces\RequestExampleInterface;
use PostmanGenerator\Interfaces\ResponseParserInterface;
use PostmanGenerator\Parsers\PostmanRequestParser;

trait PostmanApiCallTrait
{
    /**
     * Postman Collection Generator api call helper.
     *
     * @param \PostmanGenerator\CollectionGenerator $generator
     * @param \PostmanGenerator\Interfaces\ResponseParserInterface $responseParser
     * @param string $exampleName
     * @param string $requestName
     * @param string $folderName
     * @param string $method
     * @param string $uri
     * @param null|mixed[] $body
     * @param null|mixed[] $headers
     * @param null|mixed $originalBody
     *
     * @return \PostmanGenerator\Interfaces\RequestExampleInterface
     */
    public function postmanApiCall(
        CollectionGenerator $generator,
        ResponseParserInterface $responseParser,
        string $exampleName,
        string $requestName,
        string $folderName,
        string $method,
        string $uri,
        ?array $body = null,
        ?array $headers = null,
        ?array $originalBody = null
    ): RequestExampleInterface {
        $baseUrl = $generator->getConfig()->getBaseUrl();

        $requestCollection = $generator->add($folderName);

        $addedRequest = $requestCollection->addRequest(
            $requestName,
            new PostmanRequestParser(
                $method,
                $baseUrl . $uri,
                $originalBody ?? [],
                $headers ?? []
            )
        );

        return $addedRequest->addExample(
            $exampleName,
            new PostmanRequestParser(
                $method,
                $baseUrl . $uri,
                $body ?? [],
                $headers ?? []
            ),
            $responseParser
        );
    }
}
