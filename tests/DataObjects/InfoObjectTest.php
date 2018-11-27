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
        $info->setPostmanId('postman-id');

        $this->assertProperties($info, [
            'getPostmanId' => 'postman-id',
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
        $this->assertToObjectArray(InfoObject::class, [
            '_postman_id' => 'postman-id',
            'name' => 'edining v2',
            'description' => 'Description as string',
            'schema' => 'https://postman.collection.json'
        ]);
    }
}
