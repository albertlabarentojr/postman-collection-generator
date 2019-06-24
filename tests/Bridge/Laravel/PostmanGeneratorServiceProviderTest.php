<?php
declare(strict_types=1);

namespace Tests\PostmanGenerator\Bridge\Laravel;

use PostmanGenerator\Bridge\Laravel\PostmanGeneratorServiceProvider;
use PostmanGenerator\CollectionGenerator;
use PostmanGenerator\Config;
use PostmanGenerator\Interfaces\ConfigInterface;
use PostmanGenerator\Interfaces\GeneratorInterface;
use PostmanGenerator\Schemas\CollectionSchema;
use Tests\PostmanGenerator\TestCase;

/**
 * @covers \PostmanGenerator\Bridge\Laravel\PostmanGeneratorServiceProvider
 */
final class PostmanGeneratorServiceProviderTest extends TestCase
{
    /**
     * Test generated should be registered.
     *
     * @return void
     */
    public function testRegister(): void
    {
        /** @var \Illuminate\Contracts\Foundation\Application $app */
        $app = $this->getApplication();
        $provider = new PostmanGeneratorServiceProvider($app);

        $provider->register();

        $this->assertServiceInstanceOf(CollectionSchema::class, CollectionSchema::class);
        $this->assertServiceInstanceOf(ConfigInterface::class, Config::class);
        $this->assertServiceInstanceOf(GeneratorInterface::class, CollectionGenerator::class);
    }
}
