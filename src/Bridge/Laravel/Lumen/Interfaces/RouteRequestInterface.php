<?php
declare(strict_types=1);

namespace PostmanGenerator\Bridge\Laravel\Lumen\Interfaces;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use PostmanGenerator\Bridge\Laravel\Lumen\Data\RouteAction;

interface RouteRequestInterface
{
    /**
     * Get action from route.
     *
     * @param \Illuminate\Routing\Route $route
     *
     * @return \PostmanGenerator\Bridge\Laravel\Lumen\Data\RouteAction
     */
    public function getAction(Route $route): RouteAction;

    /**
     * Get matched route based on request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return null|\Illuminate\Routing\Route
     */
    public function match(Request $request): ?Route;
}
