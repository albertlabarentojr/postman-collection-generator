<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator\Schemas\Config;

use PostmanGenerator\Schemas\Config\ConfigObject;
use Tests\PostmanGenerator\SchemaTestCase;

class ConfigSchemaTest extends SchemaTestCase
{
    /**
     * Test data object properties.
     *
     * @return void
     */
    public function testProperties(): void
    {
        $config = new ConfigObject();

        $config->setExportDirectory('postman-collection.json');
        $config->setOverrideExisting(true);

        $this->assertProperties($config, [
            'getExportDirectory' => 'postman-collection.json',
            'isOverrideExisting' => true
        ]);
    }

    /**
     * Test data object as array.
     *
     * @return void
     */
    public function testToArray(): void
    {
        $this->assertToObjectArray(ConfigObject::class, [
            'export_directory' => 'postman-collection.json',
            'override_existing' => true
        ]);
    }
}