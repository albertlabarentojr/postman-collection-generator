<?php
declare(strict_types=1);

namespace PostmanGenerator\Bridge\Laravel\Lumen\Data;

use PostmanGenerator\Bridge\Laravel\Lumen\Interfaces\NamesSourceInterface;

final class AnnotationNamesSource implements NamesSourceInterface
{
    /**
     * @var mixed[]
     */
    private $classAnnotations;

    /**
     * @var \PostmanGenerator\Bridge\Laravel\Lumen\Interfaces\NamesSourceInterface
     */
    private $defaultNamesSource;

    /**
     * @var mixed[]
     */
    private $methodAnnotations;

    /**
     * AnnotationNamesSource constructor.
     *
     * @param \PostmanGenerator\Bridge\Laravel\Lumen\Interfaces\NamesSourceInterface $defaultNamesSource
     * @param mixed[] $testAnnotations
     */
    public function __construct(NamesSourceInterface $defaultNamesSource, array $testAnnotations)
    {
        $this->defaultNamesSource = $defaultNamesSource;
        $this->methodAnnotations = $testAnnotations['method'] ?? [];
        $this->classAnnotations = $testAnnotations['class'] ?? [];
    }

    /**
     * Get example name from class or method. If annotation not set, default name source is used.
     *
     * @return string
     */
    public function getExampleName(): string
    {
        return $this->methodAnnotations['PostmanExampleName'][0] ?? $this->defaultNamesSource->getExampleName();
    }

    /**
     * Get folder name from class or method. If annotation not set, default name source is used.
     *
     * @return string
     */
    public function getFolderName(): string
    {
        return $this->classAnnotations['PostmanFolderName'][0]
            ?? $this->methodAnnotations['PostmanFolderName'][0]
            ?? $this->defaultNamesSource->getFolderName();
    }

    /**
     * Get request name from class or method. If annotation not set, default name source is used.
     *
     * @return string
     */
    public function getRequestName(): string
    {
        return $this->classAnnotations['PostmanRequestName'][0]
            ?? $this->methodAnnotations['PostmanRequestName'][0]
            ?? $this->defaultNamesSource->getRequestName();
    }
}
