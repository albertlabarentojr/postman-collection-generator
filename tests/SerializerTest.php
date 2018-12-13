<?php
declare(strict_types=1);

namespace Tests\App;

use App\Serializer;

class SerializerTest extends TestCase
{
    /**
     * Test serialize object as array.
     *
     * @return void
     */
    public function testSerialize(): void
    {
        $child = [
            'grand_child_name' => 'Joe III',
            'address' => 'Sarmiento Condominium',
            'child' => null
        ];

        self::assertEquals([
            'parent_name' => 'Mr. Joe',
            'address' => 'Makati',
            'child' => [
                'child_name' => 'Joe Jr.',
                'address' => 'San antonio',
                'child' => $child,
                'children' => [$child, $child]
            ]
        ], (new Serializer())->serialize(new SerializableStub()));
    }
}
