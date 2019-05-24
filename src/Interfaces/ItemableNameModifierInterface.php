<?php
declare(strict_types=1);

namespace PostmanGenerator\Interfaces;

interface ItemableNameModifierInterface
{
    /**
     * Get modifier example name based from request.
     *
     * @return string
     */
    public function getExampleName(): string;

    /**
     * Get modified folder name based from request.
     *
     * @return string
     */
    public function getFolderName(): string;

    /**
     * Get modified request name based from request.
     *
     * @return string
     */
    public function getRequestName(): string;
}
