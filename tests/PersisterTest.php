<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator;

/**
 * @covers \PostmanGenerator\Persister
 */
final class PersisterTest extends TestCase
{
    /**
     * Resolve content to update collection items without duplicates.
     *
     * @return void
     */
    public function testResolveContentToUpdateCollectionItemsWithoutDuplicatesFromCache(): void
    {
        /** @var \PostmanGenerator\CollectionGenerator $generator1 */
        [$generator1] = $this->getRestaurantCollection();
        $generator1->generate();

        /** @var \PostmanGenerator\CollectionGenerator $generator2 */
        [$generator2] = $this->getRestaurantCollection();
        $generator2->add('Restaurant');
        $generator2->add('Restaurant');
        $generator2->add('Managers');
        $generator2->generate();

        $items = $generator2->getCollection()->getItem();

        self::assertCount(2, $items);
        self::assertEquals('Restaurant', $items[0]->toArray()['name']);
        self::assertEquals('Managers', $items[1]->toArray()['name']);

        $generator2->generate();
    }
}
