<?php
declare(strict_types=1);

namespace Tests\App\DataObjects;

use App\Objects\InfoObject;
use Tests\App\ObjectTestCase;

class InfoObjectTest extends ObjectTestCase
{
    /**
     * Test data object properties.
     *
     * @return void
     */
    public function testProperties(): void
    {
        $info = new InfoObject();

        $info->setName('edining v2');
        $info->setDescription('Description as string');
        $info->setSchema('https://postman.collection.json');

        $this->assertProperties($info, [
            'getName' => 'edining v2',
            'getDescription' => 'Description as string',
            'getSchema' => 'https://postman.collection.json'
        ]);
    }

    /**
     * Test data object as array.
     *
     * @return void
     */
    public function testToArray(): void
    {
        $data = [
            'name' => 'edining v2',
            'description' => 'Description as string',
            'schema' => 'https://schema.getpostman.com/json/collection/v2.1.0/collection.json'
        ];

        $info = new InfoObject($data);

        self::assertEquals($data + ['_postman_id' => $info->getPostmanId()], $info->toArray());
    }
}
