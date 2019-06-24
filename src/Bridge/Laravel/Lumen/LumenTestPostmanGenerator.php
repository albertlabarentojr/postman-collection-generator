<?php
declare(strict_types=1);

namespace PostmanGenerator\Bridge\Laravel\Lumen;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Laravel\Lumen\Application;
use Laravel\Lumen\Testing\TestCase;
use PostmanGenerator\Bridge\Laravel\Lumen\Data\AnnotationNamesSource;
use PostmanGenerator\Bridge\Laravel\Lumen\Data\DefaultNamesSource;
use PostmanGenerator\Bridge\Laravel\Lumen\Data\RouteAction;
use PostmanGenerator\Bridge\Laravel\Lumen\Parsers\RequestParser;
use PostmanGenerator\Bridge\Laravel\Lumen\Parsers\ResponseParser;
use PostmanGenerator\Interfaces\CollectionInterface;
use PostmanGenerator\Interfaces\GeneratorInterface;
use PostmanGenerator\Interfaces\HeaderParserInterface;
use PostmanGenerator\Interfaces\RequestExampleInterface;

/**
 * Adapter class for GeneratorInterface and lumen test case
 */
final class LumenTestPostmanGenerator
{
    /**
     * @var string[]
     */
    private static $defaultRequests = [];

    /**
     * @var \Laravel\Lumen\Application
     */
    private $app;

    /**
     * @var null|bool
     */
    private $autoInclude;

    /**
     * @var string[]
     */
    private $controllerNamespaces;

    /**
     * @var \Laravel\Lumen\Testing\TestCase
     */
    private $currentTest;

    /**
     * @var mixed[]
     */
    private $testAnnotations;

    /**
     * LumenTestPostmanGenerator constructor.
     *
     * @param \Laravel\Lumen\Application $app
     * @param \Laravel\Lumen\Testing\TestCase $currentTest
     * @param null|bool $autoInclude
     * @param null|string[] $controllerNamespaces
     */
    public function __construct(
        Application $app,
        TestCase $currentTest,
        ?bool $autoInclude = null,
        ?array $controllerNamespaces = null
    ) {
        $this->app = $app;
        $this->currentTest = $currentTest;
        $this->testAnnotations = $currentTest->getAnnotations();
        $this->autoInclude = $autoInclude ?? true;
        $this->controllerNamespaces = $controllerNamespaces ?? [];
    }

    /**
     * Generate collection for current test and merge with cached collection.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Http\Response $response
     *
     * @return void
     */
    public function generate(Request $request, Response $response): void
    {
        if ($this->include() === false) {
            return;
        }

        $routeRequest = new RouteRequest($this->app['router']);
        $route = $routeRequest->match($request);

        if ($route === null) {
            return;
        }

        $routeUri = $routeRequest->getUri($route);

        $routeAction = $routeRequest->getAction($route);

        [$folderName, $exampleName, $requestName] = $this->initData($routeAction);

        /** @var \PostmanGenerator\Interfaces\GeneratorInterface $generator */
        $generator = $this->app->get(GeneratorInterface::class);
        /** @var \PostmanGenerator\Parsers\HeaderParser $headerParser */
        $headerParser = $this->app->get(HeaderParserInterface::class);

        $baseUrl = $generator->getConfig()->getBaseUrl();

        $collection = $generator->createCollection($folderName);

        // Add request to collection.
        $collectionRequest = $this->createCollectionRequest(
            $collection,
            new RequestParser($request, $headerParser, $baseUrl),
            $folderName,
            $requestName
        );

        // Add example to request.
        $collectionRequest->addExample(
            $exampleName,
            new RequestParser($request, $headerParser, $baseUrl, $routeUri),
            new ResponseParser($response, $exampleName)
        );
        $generator->generate();
    }

    /**
     * Create collection request.
     *
     * @param \PostmanGenerator\Interfaces\CollectionInterface $collection
     * @param \PostmanGenerator\Bridge\Laravel\Lumen\Parsers\RequestParser $requestParser
     * @param string $folderName
     * @param string $requestName
     *
     * @return \PostmanGenerator\Interfaces\RequestExampleInterface
     */
    private function createCollectionRequest(
        CollectionInterface $collection,
        RequestParser $requestParser,
        string $folderName,
        string $requestName
    ): RequestExampleInterface {
        $defaultKey = Str::slug(\sprintf('%s%s', $folderName, $requestName));

        $collectionRequest = self::$defaultRequests[$defaultKey] ?? null;

        if ($collectionRequest !== null) {
            return $collectionRequest;
        }

        $collectionRequest = $collection->addRequest(
            $requestName,
            $requestParser
        );

        if ($this->isDefaultRequest() === true) {
            self::$defaultRequests[$defaultKey] = $collectionRequest;
        }

        return $collectionRequest;
    }

    /**
     * Skip if `PostmanExclude` exist to class or method annotation
     *
     * @return bool
     */
    private function exclude(): bool
    {
        return ($this->testAnnotations['class']['PostmanExclude'] ?? false)
            || ($this->testAnnotations['method']['PostmanExclude'] ?? false);
    }

    /**
     * Check if auto include is enabled.
     *
     * @return bool
     */
    private function include(): bool
    {
        if ($this->autoInclude === true && $this->exclude() === false) {
            return true;
        }

        return (($this->testAnnotations['class']['PostmanInclude'] ?? false)
                || ($this->testAnnotations['method']['PostmanInclude'] ?? false))
            && $this->exclude() === false;
    }

    /**
     * Initialise and get useful data.
     *
     * @param \PostmanGenerator\Bridge\Laravel\Lumen\Data\RouteAction $routeAction
     *
     * @return string[] - collection name, example name, request name
     */
    private function initData(RouteAction $routeAction): array
    {
        $source = new AnnotationNamesSource(
            new DefaultNamesSource(
                $routeAction,
                $this->currentTest->getName(),
                $this->controllerNamespaces
            ),
            $this->testAnnotations
        );

        return [
            $source->getFolderName(),
            $source->getExampleName(),
            $source->getRequestName()
        ];
    }

    /**
     * Is the default request to add in the postman request.
     *
     * @return bool
     */
    private function isDefaultRequest(): bool
    {
        return isset($this->testAnnotations['method']['PostmanDefaultRequest']);
    }
}
