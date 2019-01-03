<?php
declare(strict_types=1);

namespace PostmanGenerator\Interfaces;

interface PrePopulateInterface
{
    /**
     * Fill properties before mass assignment.
     *
     * @return void
     */
    public function beforeFill(): void;
}
