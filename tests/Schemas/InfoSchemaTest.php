<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator\Schemas;

use PostmanGenerator\Schemas\InfoSchema;
use Tests\PostmanGenerator\SchemaTestCase;

class InfoSchemaTest extends SchemaTestCase
{
    /**
     * Test data object properties.
     *
     * @return void
     */
    public function testProperties(): void
    {
        $info = new InfoSchema();

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

        $info = new InfoSchema($data);

        self::assertEquals($data + ['_postman_id' => $info->getPostmanId()], $info->toArray());
    }
}
