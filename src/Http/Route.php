<?php
declare(strict_types=1);

namespace PostmanGenerator\Http;

use PostmanGenerator\Interfaces\RouteInterface;

final class Route implements RouteInterface
{
    /**
     * @var \PostmanGenerator\Http\RouteData[]
     */
    private $routes;

    /**
     * Route constructor.
     *
     * @param \PostmanGenerator\Http\RouteData[] $routes
     */
    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    /**
     * Get matched resource given by a path.
     *
     * @param string $method
     * @param string $path
     *
     * @return \PostmanGenerator\Http\RouteData
     */
    public function getMatchedRoute(string $method, string $path): RouteData
    {
        $distance = [];

        foreach ($this->routes as $route) {
            if ($method !== $route->getMethod()) {
                continue;
            }

            $distance[\levenshtein($route->getResource(), $path)] = $route;
        }

        $closestDistance = \max(\array_keys($distance));

        return $distance[$closestDistance];
    }

    /**
     * Get all application route list.
     *
     * @return \PostmanGenerator\Http\RouteData[]
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }
}
