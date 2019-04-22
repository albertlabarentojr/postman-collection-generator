<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator\Schemas;

use Tests\PostmanGenerator\Stubs\ItemableSchemaStub;
use Tests\PostmanGenerator\TestCase;

/**
 * @covers \PostmanGenerator\Schemas\AbstractItemableSchema
 */
final class AbstractItemableSchemaTest extends TestCase
{
    /**
     * Should add items.
     *
     * @return void
     */
    public function testAddItems(): void
    {
        $schema = new ItemableSchemaStub(['name' => 'Parent']);
        $schema->addItems([
            new ItemableSchemaStub(['name' => 'Child1']),
            new ItemableSchemaStub(['name' => 'Child2'])
        ]);

        self::assertCount(2, $schema->getItem());
        self::assertEquals('Child1', $schema->getItem()[0]->toArray()['name']);
        self::assertEquals('Child2', $schema->getItem()[1]->toArray()['name']);
    }

    /**
     * Should add items and merge their own items.
     *
     * @return void
     */
    public function testAddItemsMergedItems(): void
    {
        $child1 = new ItemableSchemaStub(['name' => 'Child1']);
        $child1->addItem(new ItemableSchemaStub(['name' => 'Child1.0']));
        $child1->addItem(new ItemableSchemaStub(['name' => 'Child1.1']));
        $child1->addItem(new ItemableSchemaStub(['name' => 'Child1.1.1']));

        $child2 = new ItemableSchemaStub(['name' => 'Child1']);
        $child2->addItem(new ItemableSchemaStub(['name' => 'Child1.1']));
        $child2->addItem(new ItemableSchemaStub(['name' => 'Child1.1.1.1']));

        $schema = new ItemableSchemaStub(['name' => 'Parent']);
        $schema->addItems([$child1, $child2]);

        self::assertCount(1, $schema->getItem());

        /** @var \Tests\PostmanGenerator\Stubs\ItemableSchemaStub $result */
        $result = $schema->getItem()[0];

        self::assertEquals('Child1', $result->getName());
        self::assertCount(4, $result->getItem());
    }

    /**
     * Should items without duplicate.
     *
     * @return void
     */
    public function testAddItemsWithoutDuplicate(): void
    {
        $schema = new ItemableSchemaStub(['name' => 'Parent']);
        $schema->addItems([
            new ItemableSchemaStub(['name' => 'Child1']),
            new ItemableSchemaStub(['name' => 'Child1']),
            new ItemableSchemaStub(['name' => 'Child2'])
        ]);

        self::assertCount(2, $schema->getItem());
        self::assertEquals('Child1', $schema->getItem()[0]->toArray()['name']);
        self::assertEquals('Child2', $schema->getItem()[1]->toArray()['name']);
    }
}
