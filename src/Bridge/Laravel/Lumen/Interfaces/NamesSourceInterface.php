<?php
declare(strict_types=1);

namespace PostmanGenerator\Bridge\Laravel\Lumen\Interfaces;

interface NamesSourceInterface
{
    /**
     * Get example name.
     *
     * @return string
     */
    public function getExampleName(): string;

    /**
     * Get folder name.
     *
     * @return string
     */
    public function getFolderName(): string;

    /**
     * Get request name.
     *
     * @return string
     */
    public function getRequestName(): string;
}
