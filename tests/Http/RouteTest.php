<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator\Http;

use PostmanGenerator\Http\Route;
use PostmanGenerator\Http\RouteData;
use Tests\PostmanGenerator\TestCase;

/**
 * @covers \PostmanGenerator\Http\Route
 */
final class RouteTest extends TestCase
{
    /**
     * Test get matched route.
     *
     * @return void
     */
    public function testGetMatchedRoute(): void
    {
        $expectedRoute = new RouteData('POST', 'trainers/{trainerId}/pokemons');

        $routes = [
            new RouteData('GET', 'trainers/{trainerId}/pokemons'),
            $expectedRoute,
            new RouteData('POST', 'trainers/{trainerId}/pokemons/create-baby')
        ];

        self::assertSame($expectedRoute, (new Route($routes))->getMatchedRoute(
            'POST',
            'trainers/1234/pokemons'
        ));
    }

    /**
     * Test get list routes.
     *
     * @return void
     */
    public function testGetRoutes(): void
    {
        $routes = [new RouteData('GET', 'trainers/{trainerId}/pokemons')];

        self::assertEquals($routes, (new Route($routes))->getRoutes());
    }
}
