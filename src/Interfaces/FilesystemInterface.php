<?php
declare(strict_types=1);

namespace PostmanGenerator\Interfaces;

interface FilesystemInterface
{
    /**
     * Check if given file exists.
     *
     * @param string $file
     *
     * @return bool
     */
    public function exists(string $file): bool;

    /**
     * Read content of given file.
     *
     * @param string $file
     *
     * @return string
     */
    public function read(string $file): string;

    /**
     * Save given content in given file.
     *
     * @param string $file
     * @param string $content
     *
     * @return void
     */
    public function save(string $file, string $content): void;
}
