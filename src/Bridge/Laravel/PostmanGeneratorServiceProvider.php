<?php
declare(strict_types=1);

namespace PostmanGenerator\Bridge\Laravel;

use Closure;
use Illuminate\Support\ServiceProvider;
use PostmanGenerator\CollectionGenerator;
use PostmanGenerator\Config;
use PostmanGenerator\Interfaces\GeneratorInterface;
use PostmanGenerator\Schemas\CollectionSchema;
use PostmanGenerator\Schemas\VariableSchema;

final class PostmanGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Publish configuration file.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/config/postman-generator.php' => \base_path('config/postman-generator.php')
        ]);
    }

    /**
     * Register postman generator to app container.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/config/postman-generator.php', 'postman-generator');

        $this->app->singleton(GeneratorInterface::class, $this->getGeneratorInstance());
    }

    /**
     * Get generator instance.
     *
     * @return \Closure
     */
    private function getGeneratorInstance(): Closure
    {
        return function(): GeneratorInterface {
            return new CollectionGenerator(
                new CollectionSchema([
                    'name' => \config('postman-generator.schema.name'),
                    'description' => \config('postman-generator.schema.description'),
                    'variable' => [
                        new VariableSchema([
                            'key' => 'baseUrl',
                            'value' => \config('postman-generator.schema.base_url')
                        ])
                    ]
                ]),
                new Config(
                    \config('postman-generator.schema.export_directory'),
                    \config('postman-generator.schema.file_name'),
                    false,
                    '{{baseUrl}}'
                )
            );
        };
    }
}
