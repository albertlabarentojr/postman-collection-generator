<?php
declare(strict_types=1);

namespace PostmanGenerator\Bridge\Laravel\Lumen\Traits;

use Illuminate\Http\Response;
use Laravel\Lumen\Testing\TestCase as LumenTestCase;
use PostmanGenerator\Bridge\Laravel\Lumen\LumenTestPostmanGenerator;
use PostmanGenerator\Bridge\Laravel\PostmanGeneratorServiceProvider;
use RuntimeException;

/**
 * @see \Laravel\Lumen\Testing\TestCase
 * @see \Laravel\Lumen\Testing\Concerns\MakesHttpRequests
 */
trait GeneratePostmanApiCallTrait
{
    /** @var \Illuminate\Routing\RouteCollection */
    private $routeCollection;

    /**
     * Call the given URI and return the Response.
     *
     * @param string $method
     * @param string $uri
     * @param mixed[] $parameters
     * @param mixed[] $cookies
     * @param mixed[] $files
     * @param mixed[] $server
     * @param null|string $content
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Exception
     */
    public function call(
        $method,
        $uri,
        $parameters = [],
        $cookies = [],
        $files = [],
        $server = [],
        $content = null
    ): Response {
        if (\is_subclass_of($this, LumenTestCase::class) === false) {
            throw new  RuntimeException(\sprintf(
                '"%s" can only be used for subclasses of "%s"',
                'GeneratePostmanApiCallTrait',
                LumenTestCase::class
            ));
        }
        $method = \strtoupper($method);

        $response = parent::call($method, $uri, $parameters, $cookies, $files, $server, $content);

        /** @var \Illuminate\Http\Request $request */
        $request = $this->app->get('request');

        $this->app->register(PostmanGeneratorServiceProvider::class);

        (new LumenTestPostmanGenerator(
            $this->app,
            $this,
            $this->app->get('config')->get('postman-generator.options.auto_include'),
            $this->app->get('config')->get('postman-generator.options.controller_namespaces')
        ))->generate($request, $this->response);

        return $response;
    }
}
