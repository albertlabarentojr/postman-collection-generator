<?php
declare(strict_types=1);

namespace PostmanGenerator\Bridge\Laravel\Lumen;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Routing\RouteCollection;
use Laravel\Lumen\Routing\Router;
use PostmanGenerator\Bridge\Laravel\Lumen\Data\RouteAction;
use PostmanGenerator\Bridge\Laravel\Lumen\Interfaces\RouteRequestInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class RouteRequest implements RouteRequestInterface
{
    /**
     * @var \Illuminate\Routing\RouteCollection
     */
    private $routeCollection;

    /**
     * @var \Illuminate\Routing\Router
     */
    private $router;

    /**
     * @var null|bool
     */
    private $skipUndefinedRoute;

    /**
     * RouteRequest constructor.
     *
     * @param \Laravel\Lumen\Routing\Router $router
     * @param null|bool $skipUndefinedRoute
     */
    public function __construct(Router $router, ?bool $skipUndefinedRoute = null)
    {
        $this->router = $router;
        $this->skipUndefinedRoute = $skipUndefinedRoute ?? true;
    }

    /**
     * Get action.
     *
     * @param \Illuminate\Routing\Route $route
     *
     * @return \PostmanGenerator\Bridge\Laravel\Lumen\Data\RouteAction
     */
    public function getAction(Route $route): RouteAction
    {
        [$controller, $action] = \explode('@', $route->getAction('uses'));

        return new RouteAction($controller, $action);
    }

    /**
     * Get uri formatted with params for postman.
     *
     * @param \Illuminate\Routing\Route $route
     *
     * @return string
     */
    public function getUri(Route $route): string
    {
        return \str_replace(['{', '}'], ['{{', '}}'], \trim($route->uri(), '/'));
    }

    /**
     * Get matched route based on request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return null|\Illuminate\Routing\Route
     */
    public function match(Request $request): ?Route
    {
        if ($this->routeCollection !== null) {
            return $this->routeCollection->match($request);
        }

        /** @var mixed[] $routes */
        $routes = $this->router->getRoutes();

        $this->routeCollection = new RouteCollection();

        foreach ($routes as $route) {
            if (($route instanceof Route) === false) {
                $route = new Route($route['method'], $route['uri'], $route['action']);
            }

            $this->routeCollection->add($route);
        }
        try {
            return $this->routeCollection->match($request);
        } catch (NotFoundHttpException $exception) {
            if ($this->skipUndefinedRoute === false) {
                throw $exception;
            }
        }

        return null;
    }
}
