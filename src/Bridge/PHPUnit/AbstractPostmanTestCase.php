<?php
declare(strict_types=1);

namespace PostmanGenerator\Bridge\PHPUnit;

use PHPUnit\Framework\TestCase;
use PostmanGenerator\Bridge\PostmanRequestParser;
use PostmanGenerator\CollectionGenerator;
use PostmanGenerator\Interfaces\RequestExampleInterface;
use PostmanGenerator\Interfaces\ResponseParserInterface;

abstract class AbstractPostmanTestCase extends TestCase
{
    /** @var string */
    protected $collectionName;

    /**
     * Get collection generator instance.
     *
     * @return \PostmanGenerator\CollectionGenerator
     */
    abstract public function getCollectionGenerator(): CollectionGenerator;

    /**
     * Get response parser.
     *
     * @return \PostmanGenerator\Interfaces\ResponseParserInterface
     */
    abstract public function getResponseParser(): ResponseParserInterface;

    /**
     * Postman Collection Generator api call helper.
     *
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
        string $exampleName,
        string $requestName,
        string $folderName,
        string $method,
        string $uri,
        ?array $body = null,
        ?array $headers = null,
        ?array $originalBody = null
    ): RequestExampleInterface {
        $generator = $this->getCollectionGenerator();

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
            $this->getResponseParser()
        );
    }
}
