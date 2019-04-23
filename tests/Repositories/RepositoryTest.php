<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator\Repositories;

use PostmanGenerator\Repositories\Repository;
use PostmanGenerator\Schemas\CollectionItemSchema;
use Tests\PostmanGenerator\TestCase;

/**
 * @covers \PostmanGenerator\Repositories\Repository
 */
final class RepositoryTest extends TestCase
{
    /**
     * Test find collection item schema from collection.
     *
     * @return void
     */
    public function testFind(): void
    {
        /** @var \PostmanGenerator\CollectionGenerator $generator */
        [$generator] = $this->getRestaurantCollection();

        $repository = new Repository();

        /** @var \PostmanGenerator\Schemas\CollectionItemSchema $collectionItem */
        $collectionItem = $repository->find(
            $generator->getCollection(),
            new CollectionItemSchema(['name' => 'Restaurant'])
        );

        self::assertNotNull($collectionItem);
        self::assertCount(2, $collectionItem->getItem());
    }

    /**
     * Test find if not found should return null.
     *
     * @return void
     */
    public function testFindNotFoundWillReturnNull(): void
    {
        /** @var \PostmanGenerator\CollectionGenerator $generator */
        [$generator] = $this->getRestaurantCollection();

        $repository = new Repository();

        self::assertNull($repository->find(
            $generator->getCollection(),
            new CollectionItemSchema(['name' => 'Not-Existing-Item'])
        ));
    }
}
