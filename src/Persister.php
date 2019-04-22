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
     * Get cached collection schema.
     *
     * @param \PostmanGenerator\Interfaces\ConfigInterface $config
     *
     * @return null|\PostmanGenerator\Schemas\CollectionSchema
     */
    public function getCachedCollection(ConfigInterface $config): ?CollectionSchema
    {
        $filename = $this->resolveFilename($config->getFilename(), $config->overrideExistingCollection());
        $cachedFilePath = \sprintf('%s/%s-cached', $config->getExportDir(), $filename);

        if ($this->filesystem->exists($cachedFilePath) === false) {
            return null;
        }

        /** @noinspection UnserializeExploitsInspection */
        return \unserialize($this->filesystem->read($cachedFilePath));
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
        $this->persistCollection($config, $collection);
        $this->persistCollectionCache($config, $collection);
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
     * Persist collection to storage.
     *
     * @param \PostmanGenerator\Interfaces\ConfigInterface $config
     * @param \PostmanGenerator\Schemas\CollectionSchema $collection
     *
     * @return void
     */
    private function persistCollection(ConfigInterface $config, CollectionSchema $collection): void
    {
        $filename = $this->resolveFilename($config->getFilename(), $config->overrideExistingCollection());
        $filePath = $this->getFilePath($config, $filename);
        $content = $this->resolveContent($collection, $config);

        $this->filesystem->save($filePath, $content);
    }

    /**
     * Persist collection cache to storage.
     *
     * @param \PostmanGenerator\Interfaces\ConfigInterface $config
     * @param \PostmanGenerator\Schemas\CollectionSchema $collection
     *
     * @return void
     */
    private function persistCollectionCache(ConfigInterface $config, CollectionSchema $collection): void
    {
        $filename = $this->resolveFilename($config->getFilename(), $config->overrideExistingCollection());
        $cachedFilePath = \sprintf('%s/%s-cached', $config->getExportDir(), $filename);

        $this->filesystem->save($cachedFilePath, \serialize($collection));
    }

    /**
     * Resolve content.
     *
     * @param \PostmanGenerator\Schemas\CollectionSchema $collection
     * @param \PostmanGenerator\Interfaces\ConfigInterface $config
     *
     * @return string
     */
    private function resolveContent(CollectionSchema $collection, ConfigInterface $config): string
    {
        $fromCache = $this->getCachedCollection($config);

        if ($fromCache !== null) {
            $collection->addItems($fromCache->getItem());
        }

        return \json_encode($this->serializer->serialize($collection));
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
