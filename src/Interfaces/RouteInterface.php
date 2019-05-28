<?php
declare(strict_types=1);

namespace PostmanGenerator\Interfaces;

use PostmanGenerator\Http\RouteData;

interface RouteInterface
{
    /**
     * Get all application route list.
     *
     * @return string[]
     */
    public function getRoutes(): array;

    /**
     * Get matched resource given by a path.
     *
     * @param string $method
     * @param string $path
     *
     * @return \PostmanGenerator\Http\RouteData
     */
    public function getMatchedRoute(string $method, string $path): RouteData;
}
