<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator\Stubs;

use Laravel\Lumen\Application;
use Laravel\Lumen\Testing\TestCase;
use PostmanGenerator\Bridge\Laravel\Lumen\Traits\GeneratePostmanApiCallTrait;
use PostmanGenerator\CollectionGenerator;
use PostmanGenerator\Config;
use PostmanGenerator\Interfaces\ResponseParserInterface;
use PostmanGenerator\Schemas\CollectionSchema;
use PostmanGenerator\Schemas\ResponseSchema;

final class PostmanTestCaseStub extends TestCase
{
    use GeneratePostmanApiCallTrait;

    /** @var \PostmanGenerator\CollectionGenerator */
    private $generator;

    /** @var \PostmanGenerator\Interfaces\ResponseParserInterface */
    private $responseParser;

    /**
     * Creates the application.
     *
     * Needs to be implemented by subclasses.
     */
    public function createApplication()
    {
        return $this->app = new Application(__DIR__);
    }

    /**
     * Get collection generator instance.
     *
     * @return \PostmanGenerator\CollectionGenerator
     */
    public function getCollectionGenerator(): CollectionGenerator
    {
        return $this->generator ?? new CollectionGenerator(
                new CollectionSchema(),
                new Config(__DIR__, 'collection')
            );
    }

    /**
     * Get response parser.
     *
     * @return \PostmanGenerator\Interfaces\ResponseParserInterface
     */
    public function getResponseParser(): ResponseParserInterface
    {
        return $this->responseParser ?? $this->getResponseParserInstance();
    }

    /**
     * Get response parser.
     *
     * @return mixed|\PostmanGenerator\Interfaces\ResponseParserInterface
     */
    public function getResponseParserInstance()
    {
        return new class() implements ResponseParserInterface
        {
            /**
             * Parse response from given data.
             *
             * @return \PostmanGenerator\Schemas\ResponseSchema
             */
            public function parse(): ResponseSchema
            {
                return new ResponseSchema();
            }
        };
    }

    /**
     * Set collection generator.
     *
     * @param \PostmanGenerator\CollectionGenerator $generator
     *
     * @return \Tests\PostmanGenerator\Stubs\PostmanTestCaseStub
     */
    public function setGenerator(CollectionGenerator $generator): self
    {
        $this->generator = $generator;

        return $this;
    }

    /**
     * Set response parser.
     *
     * @param \PostmanGenerator\Interfaces\ResponseParserInterface $responseParser
     *
     * @return \Tests\PostmanGenerator\Stubs\PostmanTestCaseStub
     */
    public function setResponseParser(ResponseParserInterface $responseParser): self
    {
        $this->responseParser = $responseParser;

        return $this;
    }

    public function testOne(): void
    {
        self::assertTrue(true);
    }
}
