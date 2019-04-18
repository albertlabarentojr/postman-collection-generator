<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator\Schemas;

use PostmanGenerator\Schemas\UrlSchema;
use Tests\PostmanGenerator\SchemaTestCase;

/**
 * @covers \PostmanGenerator\Schemas\UrlSchema
 */
class UrlSchemaTest extends SchemaTestCase
{
    /**
     * Test data object properties.
     *
     * @return void
     */
    public function testProperties(): void
    {
        $url = new UrlSchema();

        $raw = '{{base_url}}/restaurants/{{restaurant_id}}/staff-members/{{staff_member_id}}';
        $path = [
            'restaurants',
            '{{restaurant_id}}',
            'staff-members',
            '{{staff_member_id}}'
        ];

        $url->setRaw($raw);
        $url->setProtocol('protocol-test');
        $url->setHost(['{{base_url}}']);
        $url->setPath($path);

        $this->assertProperties($url, [
            'getRaw' => $raw,
            'getProtocol' => 'protocol-test',
            'getHost' => ['{{base_url}}'],
            'getPath' => $path
        ]);
    }

    /**
     * Test data object as array.
     *
     * @return void
     */
    public function testToArray(): void
    {
        $this->assertToObjectArray(UrlSchema::class, [
            'raw' => 'test-raw',
            'protocol' => 'protocol-tests',
            'host' => ['host-test'],
            'path' => ['test-path']
        ]);
    }
}
