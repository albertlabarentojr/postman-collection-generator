<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator\Traits;

use PostmanGenerator\Config;
use Tests\PostmanGenerator\Stubs\PostmanTestCaseStub;
use Tests\PostmanGenerator\TestCase;

/**
 * @covers \PostmanGenerator\Bridge\PHPUnit\AbstractPostmanTestCase
 */
final class PostmanApiCallTraitTest extends TestCase
{
    /**
     * Test api call to create collection request with postman example.
     *
     * @return void
     */
    public function testApiCallCreateCollections(): void
    {
        $config = new Config($this->collectionDir, $this->collectionFile);

        $generator = $this->getCollectionGenerator($config);

        $instance1 = new PostmanTestCaseStub();
        $instance1->setGenerator($generator);

        $instance1->postmanApiCall(
            $instance1->getCollectionGenerator(),
            $instance1->getResponseParser(),
            'Create Pokemon Successful',
            'Create Pokemon',
            'Pokemons',
            'POST',
            'api/v1/pokemons',
            ['pokemon_name' => 'Pikachu'],
            ['Authentication' => 'Bearer: AuthToken']
        );

        $instance1->postmanApiCall(
            $instance1->getCollectionGenerator(),
            $instance1->getResponseParser(),
            'Create Trainer Successful',
            'Create Trainer',
            'Trainers',
            'POST',
            'api/v1/trainers',
            ['trainer_name' => 'Trainer'],
            ['Authentication' => 'Bearer: AuthToken']
        );

        /** @var \Countable|\PostmanGenerator\Schemas\CollectionItemSchema[] $items */
        $items = $generator->getCollection()->getItem();

        self::assertCount(2, $items);

        self::assertEquals('Pokemons', $items[0]->getName());
        self::assertCount(1, $items[0]->getItem());

        // Assert Pokemon collection.
        /** @var \PostmanGenerator\Schemas\ItemSchema[] $pokemonRequests */
        $pokemonRequests = $items[0]->getItem();
        self::assertEquals('Create Pokemon', $pokemonRequests[0]->getName());
        self::assertEquals(
            \sprintf('%s%s', $config->getBaseUrl(), 'api/v1/pokemons'),
            $pokemonRequests[0]->getRequest()->getUrl()
        );
        self::assertEquals(\json_encode(['pokemon_name' => 'Pikachu']),
            $pokemonRequests[0]->getRequest()->getBody()->getRaw());
        self::assertEquals('Authentication', $pokemonRequests[0]->getRequest()->getHeader()[0]->getKey());
        self::assertEquals('Bearer: AuthToken', $pokemonRequests[0]->getRequest()->getHeader()[0]->getValue());

        /** @var \PostmanGenerator\Schemas\ResponseSchema[] $pokemonExamples */
        $pokemonExamples = $pokemonRequests[0]->getResponse();
        self::assertEquals('Create Pokemon Successful', $pokemonExamples[0]->getName());

        // Assert Trainer collection.
        /** @var \PostmanGenerator\Schemas\ItemSchema[] $trainerRequests */
        $trainerRequests = $items[1]->getItem();
        self::assertEquals('Create Trainer', $trainerRequests[0]->getName());
        self::assertEquals(
            \sprintf('%s%s', $config->getBaseUrl(), 'api/v1/trainers'),
            $trainerRequests[0]->getRequest()->getUrl()
        );
        self::assertEquals(\json_encode(['trainer_name' => 'Trainer']),
            $trainerRequests[0]->getRequest()->getBody()->getRaw());
        self::assertEquals('Authentication', $trainerRequests[0]->getRequest()->getHeader()[0]->getKey());
        self::assertEquals('Bearer: AuthToken', $trainerRequests[0]->getRequest()->getHeader()[0]->getValue());

        /** @var \PostmanGenerator\Schemas\ResponseSchema[] $pokemonExamples */
        $trainerExamples = $trainerRequests[0]->getResponse();
        self::assertEquals('Create Trainer Successful', $trainerExamples[0]->getName());
    }
}
