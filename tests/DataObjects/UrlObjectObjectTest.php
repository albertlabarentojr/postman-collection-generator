<?php
declare(strict_types=1);

namespace Tests\App\DataObjects;

use App\Objects\UrlObject;
use Tests\App\ObjectTestCase;

/**
 * @covers \App\Objects\UrlObject
 */
class UrlObjectObjectTest extends ObjectTestCase
{
    /**
     * Test data object properties.
     *
     * @return void
     */
    public function testProperties(): void
    {
        $url = new UrlObject();

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
        $this->assertToObjectArray(UrlObject::class, [
            'raw' => 'test-raw',
            'protocol' => 'protocol-tests',
            'host' => ['host-test'],
            'path' => ['test-path']
        ]);
    }
}
