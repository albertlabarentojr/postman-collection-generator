<?php
declare(strict_types=1);

namespace PostmanGenerator;

use PostmanGenerator\Filesystems\LocalFilesystem;
use PostmanGenerator\Interfaces\ConfigInterface;
use PostmanGenerator\Interfaces\FilesystemInterface;
use PostmanGenerator\Interfaces\PersisterInterface;
use PostmanGenerator\Interfaces\SerializerInterface;
use PostmanGenerator\Schemas\CollectionSchema;

final class Persister implements PersisterInterface
{
    /** @var \PostmanGenerator\Interfaces\FilesystemInterface */
    private $filesystem;

    /** @var \PostmanGenerator\Interfaces\SerializerInterface */
    private $serializer;

    /**
     * Persister constructor.
     *
     * @param null|\PostmanGenerator\Interfaces\FilesystemInterface $filesystem
     * @param null|\PostmanGenerator\Interfaces\SerializerInterface $serializer
     */
    public function __construct(?FilesystemInterface $filesystem = null, ?SerializerInterface $serializer = null)
    {
        $this->filesystem = $filesystem ?? new LocalFilesystem();
        $this->serializer = $serializer ?? new Serializer();
    }

    /**
     * Get serializer.
     *
     * @return \PostmanGenerator\Interfaces\SerializerInterface
     */
    public function getSerializer(): SerializerInterface
    {
        return $this->serializer;
    }

    /**
     * Persist collection for given config.
     *
     * @param \PostmanGenerator\Interfaces\ConfigInterface $config
     * @param \PostmanGenerator\Schemas\CollectionSchema $collection
     *
     * @return void
     */
    public function persist(ConfigInterface $config, CollectionSchema $collection): void
    {
        $filename = $this->resolveFilename($config->getFilename(), $config->overrideExistingCollection());
        $filepath = $this->getFilePath($config, $filename);
        $content = $this->resolveContent($collection, $filepath, $config->overrideExistingCollection());

        $this->filesystem->save($filepath, $content);
    }

    /**
     * Get file path for given config.
     *
     * @param \PostmanGenerator\Interfaces\ConfigInterface $config
     * @param string $filename
     *
     * @return string
     */
    private function getFilePath(ConfigInterface $config, string $filename): string
    {
        return \sprintf('%s/%s.json', $config->getExportDir(), $filename);
    }

    /**
     * Resolve content.
     *
     * @param \PostmanGenerator\Schemas\CollectionSchema $collection
     * @param string $file
     * @param bool $override
     *
     * @return string
     */
    private function resolveContent(CollectionSchema $collection, string $file, bool $override): string
    {
        $data = $this->serializer->serialize($collection);

        if ($override) {
            $existing = \json_decode($this->filesystem->read($file), true) ?? [];

            $data['item'] = \array_merge($existing['item'] ?? [], $data['item'] ?? []);
        }

        return \json_encode($data);
    }

    /**
     * Resolve new filename.
     *
     * @param string $filename
     * @param bool $override
     *
     * @return string
     */
    private function resolveFilename(string $filename, bool $override): string
    {
        if ($this->filesystem->exists($filename) === false || $override) {
            return $filename;
        }

        $index = 1;

        do {
            $filename = \sprintf('%s-%d.json', $filename, $index);
            $index++;
        } while ($this->filesystem->exists($filename) === false);

        return $filename;
    }
}
