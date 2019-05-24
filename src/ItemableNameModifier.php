<?php
declare(strict_types=1);

namespace PostmanGenerator;

use PostmanGenerator\Interfaces\ItemableNameModifierInterface;

final class ItemableNameModifier implements ItemableNameModifierInterface
{
    /**
     * @var string
     */
    private $method;

    /**
     * @var int
     */
    private $statusCode;

    /**
     * @var string
     */
    private $testCase;

    /**
     * @var string
     */
    private $url;

    /**
     * ItemableNameModifier constructor.
     *
     * @param string $url
     * @param string $method
     * @param int $statusCode
     * @param null|string $testCase
     */
    public function __construct(string $url, string $method, int $statusCode, ?string $testCase = null)
    {
        $this->url = $url;
        $this->statusCode = $statusCode;
        $this->testCase = $testCase;
        $this->method = $method;
    }

    /**
     * Get modifier example name based from request.
     *
     * @return string
     */
    public function getExampleName(): string
    {
        return 'Successful';
    }

    /**
     * Get modified folder name based from request.
     *
     * @return string
     */
    public function getFolderName(): string
    {
        return 'Trainers';
    }

    /**
     * Get modified request name based from request.
     *
     * @return string
     */
    public function getRequestName(): string
    {
        return 'Trainers';
    }
}
