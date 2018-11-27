<?php
declare(strict_types=1);

namespace Tests\App\DataObjects;

use App\Objects\FileObject;
use Tests\App\ObjectTestCase;

class FileObjectObjectTest extends ObjectTestCase
{
    /**
     * Test data object properties.
     *
     * @return void
     */
    public function testProperties(): void
    {
        $file = new FileObject();

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

        self::assertEquals((new FileObject(['content' => 'test-content', 'source' => 'test-source']))->toArray(), [
            'content' => 'test-content',
            'src' => 'test-source'
        ]);
    }
}
