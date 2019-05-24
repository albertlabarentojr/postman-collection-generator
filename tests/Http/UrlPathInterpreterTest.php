<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator\Http;

use PostmanGenerator\Http\ResourceData;
use PostmanGenerator\Http\UrlPath;
use Tests\PostmanGenerator\TestCase;

/**
 * @covers \PostmanGenerator\Http\UrlPath
 */
final class UrlPathInterpreterTest extends TestCase
{
    /**
     * Get fragments from a given resource endpoint.
     *
     * @param string $endpoint
     * @param string[] $fragments
     *
     * @dataProvider getFragmentsProvider
     *
     * @return void
     */
    public function testGetFragments(string $endpoint, array $fragments): void
    {
        self::assertEquals((new UrlPath())->getFragments($endpoint), $fragments);
    }

    /**
     * Test if fragment is a resource id.
     *
     * @param string $fragment
     * @param bool $expectedResult
     *
     * @dataProvider isResourceIdProvider
     *
     * @return void
     */
    public function testIsResourceId(string $fragment, bool $expectedResult): void
    {
        self::assertEquals((new UrlPath())->isResourceId($fragment), $expectedResult);
    }

    /**
     * Test if fragment is a resource name.
     *
     * @param string $fragment
     * @param bool $expectedResult
     *
     * @dataProvider isResourceNamesProvider
     *
     * @return void
     */
    public function testIsResourceName(string $fragment, bool $expectedResult): void
    {
        self::assertEquals((new UrlPath())->isResourceName($fragment), $expectedResult);
    }

    /**
     * Test fragment to resource.
     *
     * @param string $path
     * @param \PostmanGenerator\Http\ResourceData $resource
     *
     * @dataProvider pathToResourceProvider
     *
     * @return void
     */
    public function testPathToResource(string $path, ResourceData $resource): void
    {
        self::assertEquals((new UrlPath())->pathToResource($path)->getNestedResource(), $resource->getNestedResource());
        self::assertEquals((new UrlPath())->pathToResource($path)->getResource(), $resource->getResource());
    }

    /**
     * Get fragments provider.
     *
     * @return mixed[]
     */
    private function getFragmentsProvider(): array
    {
        return [
            [
                '/trainers',
                ['trainers']
            ],
            [
                '/trainers/123',
                ['trainers', 'trainer_id' => 'trainerId']
            ],
            [
                '/trainers/{{trainerId}}/pokemons/{{pokemonId}}',
                ['trainers', 'trainer_id' => 'trainerId', 'pokemons', 'pokemon_id' => 'pokemonId']
            ],
            [
                '/trainers/123/pokemons/pikachu-external-id',
                ['trainers', 'trainer_id' => 'trainerId', 'pokemons', 'pokemon_slug' => 'slug']
            ],
            [
                '/pokeballs/throw',
                ['pokeballs-throw']
            ]
        ];
    }

    /**
     * Is resource id provider.
     *
     * @return mixed[]
     */
    private function isResourceIdProvider(): array
    {
        return [
            ['trainers', false],
            ['{{trainerId}}', true],
            ['trainerId', true],
            ['create-pokemon', false]
        ];
    }

    /**
     * Is resource name provider.
     *
     * @return mixed[]
     */
    private function isResourceNamesProvider(): array
    {
        // [fragment, expectedResult - isResourceName()]
        return [
            ['trainers', true],
            ['{{trainerId}}', false],
            ['trainerId', false],
            ['create-pokemon', true]
        ];
    }

    /**
     * Path to resource provider
     *
     * @return mixed[]
     */
    private function pathToResourceProvider(): array
    {
        return [
            ['/trainers', new ResourceData('Trainers', 'Trainers')],
            ['/trainers/123', new ResourceData('Trainers', 'Trainer')],
            ['/trainers/trainerId/create-baby-pokemon', new ResourceData('Trainer', 'Create Baby Pokemon')],
            ['/trainers/123/pokemons', new ResourceData('Trainers.Pokemons', 'Pokemons')],
            ['/trainers/123/pokemons/123', new ResourceData('Trainers.Pokemons', 'Pokemon')],
            ['trainers/123/pokemons/type', new ResourceData('Trainers.PokemonsType', 'PokemonsType')],
            ['trainers/123/pokemons/grass', new ResourceData('Trainers.PokemonsType', 'Pokemons Type')],
            ['trainers?name="Ash Lee"', new ResourceData('Trainers.PokemonsType', 'Pokemons Type', 'Filter by Name')],
            [
                'trainers?offset=1&limit=5',
                new ResourceData('Trainers.PokemonsType', 'Pokemons Type', 'Paginated Offset by 1 and Limit by 5')
            ],
            ['trainers?page=1', new ResourceData('Trainers.PokemonsType', 'Pokemons Type', 'Paginated Page by 1')],
            ['trainers?sort=asc', new ResourceData('Trainers.PokemonsType', 'Pokemons Type', 'Sort Asc')],
            ['trainers?sort=desc', new ResourceData('Trainers.PokemonsType', 'Pokemons Type', 'Sort Desc')]
        ];
    }
}
