<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator\Schemas;

use PostmanGenerator\Schemas\FileSchema;
use Tests\PostmanGenerator\SchemaTestCase;

class FileSchemaSchemaTest extends SchemaTestCase
{
    /**
     * Test data object properties.
     *
     * @return void
     */
    public function testProperties(): void
    {
        $file = new FileSchema();

        $file->setSource('test-source');
        $file->setContent('test-content');

        $this->assertProperties($file, [
            'getSource' => 'test-source',
            'getContent' => 'test-content'
        ]);
    }

    /**
     * Test data object as array.
     *
     * @return void
     */
    public function testToArray(): void
    {
        self::assertEquals((new FileSchema(['content' => 'test-content', 'source' => 'test-source']))->toArray(), [
            'content' => 'test-content',
            'src' => 'test-source'
        ]);
    }
}
