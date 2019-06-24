<?php
declare(strict_types=1);

namespace PostmanGenerator\Bridge\Laravel;

use Closure;
use Illuminate\Support\ServiceProvider;
use PostmanGenerator\CollectionGenerator;
use PostmanGenerator\Config;
use PostmanGenerator\Interfaces\ConfigInterface;
use PostmanGenerator\Interfaces\GeneratorInterface;
use PostmanGenerator\Interfaces\HeaderParserInterface;
use PostmanGenerator\Parsers\HeaderParser;
use PostmanGenerator\Schemas\CollectionSchema;
use PostmanGenerator\Schemas\InfoSchema;
use PostmanGenerator\Schemas\VariableSchema;
use Symfony\Component\Yaml\Parser as YamlParser;

final class PostmanGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Register postman generator to app container.
     *
     * @return void
     */
    public function register(): void
    {
        // Read yaml file and merge into config.
        $this->yamlToConfig(\base_path('postman-generator.yaml'), 'postman-generator');

        $this->app->singleton(CollectionSchema::class, $this->getCollectionSchemaInstance());
        $this->app->singleton(ConfigInterface::class, $this->getConfigInstance());
        $this->app->singleton(GeneratorInterface::class, function (): GeneratorInterface {
            return new CollectionGenerator(
                $this->app->make(CollectionSchema::class),
                $this->app->make(ConfigInterface::class)
            );
        });

        $this->app->singleton(HeaderParserInterface::class, static function (): HeaderParserInterface {
            return new HeaderParser(
                \config('postman-generator.options.http_headers.include'),
                \config('postman-generator.options.http_headers.exclude')
            );
        });
    }

    /**
     * Get collection schema instance.
     *
     * @return \Closure
     */
    private function getCollectionSchemaInstance(): Closure
    {
        return static function (): CollectionSchema {
            $collection = new CollectionSchema([
                'info' => new InfoSchema([
                    'name' => \config('postman-generator.info.name'),
                    'description' => \config('postman-generator.info.description')
                ]),
                'variable' => [
                    new VariableSchema([
                        'key' => 'baseUrl',
                        'value' => \config('postman-generator.info.base_url')
                    ])
                ]
            ]);

            return $collection;
        };
    }

    /**
     * Get config instance.
     *
     * @return \Closure
     */
    private function getConfigInstance(): Closure
    {
        return static function (): ConfigInterface {
            return new Config(
                \base_path(),
                \config('postman-generator.info.file_name'),
                false,
                \config('postman-generator.info.base_url', '{{baseUrl}}')
            );
        };
    }

    /**
     * Parse yaml file and merge into config repository.
     *
     * @param string $yamlFile
     * @param string $key
     *
     * @return void
     */
    private function yamlToConfig(string $yamlFile, string $key): void
    {
        $yamlParser = new YamlParser();

        $parsedConfig = $yamlParser->parseFile($yamlFile);

        $currentConfig = $this->app->get('config')->get($key, []);

        $this->app->get('config')->set($key, \array_merge($parsedConfig, $currentConfig));
    }
}
