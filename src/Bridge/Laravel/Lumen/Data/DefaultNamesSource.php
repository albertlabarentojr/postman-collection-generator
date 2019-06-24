<?php
declare(strict_types=1);

namespace PostmanGenerator\Bridge\Laravel\Lumen\Data;

use Illuminate\Support\Str;
use PostmanGenerator\Bridge\Laravel\Lumen\Interfaces\NamesSourceInterface;

final class DefaultNamesSource implements NamesSourceInterface
{
    /**
     * @var string[]
     */
    private $baseNamespaces;

    /**
     * @var string
     */
    private $exampleName;

    /**
     * @var string
     */
    private $folderName;

    /**
     * @var string
     */
    private $requestName;

    /**
     * @var \PostmanGenerator\Bridge\Laravel\Lumen\Data\RouteAction
     */
    private $routeAction;

    /**
     * @var string
     */
    private $testFunction;

    /**
     * DefaultNameSource constructor.
     *
     * @param \PostmanGenerator\Bridge\Laravel\Lumen\Data\RouteAction $routeAction
     * @param string $testFunction
     * @param null|string[] $baseNamespace
     */
    public function __construct(
        RouteAction $routeAction,
        string $testFunction,
        ?array $baseNamespace = null
    ) {
        $this->routeAction = $routeAction;
        $this->testFunction = $testFunction;

        $this->baseNamespaces = $baseNamespace ?? ['App\\Http\\Controllers\\'];

        $this->initialise();
    }

    /**
     * Get example name.
     *
     * @return string
     */
    public function getExampleName(): string
    {
        return $this->guessExampleName();
    }

    /**
     * Get folder name.
     *
     * @return string
     */
    public function getFolderName(): string
    {
        return $this->guessFolderName();
    }

    /**
     * Get request name.
     *
     * @return string
     */
    public function getRequestName(): string
    {
        return $this->guessRequestName();
    }

    /**
     * Retrieve test function caller.
     *
     * @return string
     */
    private function getTestFunctionCaller(): string
    {
        if ($this->testFunction !== null) {
            return $this->testFunction;
        }

        $trace = \debug_backtrace(\DEBUG_BACKTRACE_IGNORE_ARGS, 20);

        foreach ($trace as $file) {
            if (Str::startsWith($file['function'], 'test') === false) {
                continue;
            }

            return $this->testFunction = $file['function'];
        }

        return '';
    }

    /**
     * Guess example name from test method.
     *
     * @return string
     */
    private function guessExampleName(): string
    {
        if ($this->exampleName !== null) {
            return $this->exampleName;
        }

        $exampleName = $this->getTestFunctionCaller();

        $requestName = \trim($this->guessRequestName());

        // Default to request name and append example.
        if ($exampleName === '') {
            return $this->exampleName = \sprintf('%s example', $requestName);
        }

        // Remove `test` word from method
        if (\strpos($exampleName, 'test') !== false) {
            $exampleName = \ltrim($exampleName, 'test');
        }

        $exampleName = $this->toSentence($exampleName);

        // Remove request name from sentence to avoid redundancy.
        if (\str_word_count($requestName) > 1) {
            $exampleName = \str_replace(\strtolower($requestName), '', \strtolower($exampleName));
        }
        if ($exampleName === '') {
            return $this->exampleName = \ucwords(\trim($requestName));
        }

        return $this->exampleName = \ucwords(\trim($exampleName));
    }

    /**
     * Build collection name from controller class.
     *
     * @return string
     */
    private function guessFolderName(): string
    {
        if ($this->folderName !== null) {
            return $this->folderName;
        }

        $this->folderName = $this->routeAction->getController();

        // Remove base namespace from controller class
        foreach ($this->baseNamespaces as $namespace) {
            $this->folderName = \str_replace($namespace, '', $this->folderName);
        }

        // Strip `Controller` text
        // Replace backslash with `.`
        // Result should be MyFolder.MyClass
        return $this->folderName = \trim(\str_replace(
            ['Controller', '\\'],
            ['', '.'],
            $this->folderName
        ), '.');
    }

    /**
     * Guess request name from route action and folder name.
     *
     * @return string
     */
    private function guessRequestName(): string
    {
        if ($this->requestName !== null) {
            return $this->requestName;
        }
        $method = $this->routeAction->getMethod();

        // From camelCase method convention, parse too snake case
        $requestName = $this->toSentence($method);

        if (\str_word_count($method) !== 1) {
            return $this->requestName = $requestName;
        }

        $folderName = $this->guessFolderName();

        $collection = \explode('.', $folderName);

        $resource = Str::singular(\end($collection));

        if ($method === '__invoke') {
            return $this->toSentence($resource);
        }

        return $this->requestName = \sprintf('%s %s', $requestName, $resource);
    }

    /**
     * Initialise required data.
     *
     * @return void
     */
    private function initialise(): void
    {
        $this->getTestFunctionCaller();

        $this->guessFolderName();
        $this->guessExampleName();
        $this->guessRequestName();
    }

    /**
     * Convert to sentence case.
     *
     * @param string $input
     *
     * @return mixed
     */
    private function toSentence(string $input): string
    {
        return \ucwords(\str_replace('_', ' ', \strtolower(Str::snake($input))));
    }
}
