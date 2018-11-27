<?php
declare(strict_types=1);

namespace Tests\App\DataObjects;

use App\Objects\DescriptionObject;
use Tests\App\ObjectTestCase;

/**
 * @covers \App\Objects\DescriptionObject
 */
class DescriptionObjectTest extends ObjectTestCase
{
    /**
     * Test description properties.
     *
     * @return void
     */
    public function testProperties(): void
    {
        $description = new DescriptionObject();

        $description->setType('type-test');
        $description->setContent('content-test');

        $this->assertProperties($description, ['getType' => 'type-test', 'getContent' => 'content-test']);
    }

    /**
     * Test description with default type.
     */
    public function testGetDescriptionWithDefaultType(): void
    {
        $description = new DescriptionObject();

        self::assertEquals('text/markdown', $description->getType());
    }

    /**
     * Test object to array.
     *
     * @return void
     */
    public function testToArray(): void
    {
        $this->assertToObjectArray(DescriptionObject::class, [
            'content' => 'content-test',
            'type' => 'type-test'
        ]);
    }
}
