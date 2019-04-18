<?php
declare(strict_types=1);

namespace PostmanGenerator\Filesystems;

use PostmanGenerator\Interfaces\FilesystemInterface;
use Symfony\Component\Filesystem\Filesystem;

final class LocalFilesystem implements FilesystemInterface
{
    /** @var \Symfony\Component\Filesystem\Filesystem */
    private $filesystem;

    /**
     * LocalFilesystem constructor.
     */
    public function __construct()
    {
        $this->filesystem = new Filesystem();
    }

    /**
     * Check if given file exists.
     *
     * @param string $file
     *
     * @return bool
     */
    public function exists(string $file): bool
    {
        return $this->filesystem->exists($file);
    }

    /**
     * Read content of given file.
     *
     * @param string $file
     *
     * @return string
     */
    public function read(string $file): string
    {
        return $this->filesystem->exists($file) ? \file_get_contents($file) : '';
    }

    /**
     * Save given content in given file.
     *
     * @param string $file
     * @param string $content
     *
     * @return void
     */
    public function save(string $file, string $content): void
    {
        $this->filesystem->dumpFile($file, $content);
    }
}
