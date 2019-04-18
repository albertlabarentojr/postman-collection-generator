<?php
declare(strict_types=1);

namespace PostmanGenerator\Schemas;

use PostmanGenerator\Exceptions\InvalidMethodCallException;
use PostmanGenerator\Interfaces\CollectionSchemaInterface;
use PostmanGenerator\Interfaces\PrePopulateInterface;

abstract class AbstractSchema implements CollectionSchemaInterface
{
    /**
     * AbstractDataObject constructor.
     *
     * @param mixed[] $data
     */
    public function __construct(?array $data = [])
    {
        $this->fill($data ?? []);
    }

    /**
     * Call method.
     *
     * @param string $method
     * @param mixed $arguments
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function __call(string $method, $arguments)
    {
        $types = ['is', 'get', 'set'];

        // Break calling method into type (get, has, is, set) and attribute
        \preg_match('/^(' . \implode('|', $types) . ')([a-zA-Z][\w]+)$/i', $method, $matches);

        $type = \mb_strtolower($matches[1] ?? '');
        $property = \lcfirst($matches[2] ?? '');

        // The property being accessed must exist and the type must be valid if one of these things
        // aren't true throw an exception
        if ((new \ReflectionClass($this))->hasProperty($property) === false) {
            throw new InvalidMethodCallException(
                \sprintf('Call to undefined method %s::%s()', \get_class($this), $method)
            );
        }

        $resolvedProperty = null;

        // Perform action - code coverage disabled due to phpdbg not seeing case statements
        switch ($type) {
            // @codeCoverageIgnoreStart
            case 'get':
                // @codeCoverageIgnoreEnd
                $resolvedProperty = $this->get($property);
                break;

            // @codeCoverageIgnoreStart
            case 'is':
                // @codeCoverageIgnoreEnd
                // Always return a boolean
                $resolvedProperty = $this->is($property);
                break;

            // @codeCoverageIgnoreStart
            case 'set':
                // @codeCoverageIgnoreEnd
                // Return original instance for fluency
                $resolvedProperty = $this->set($property, $arguments[0]);
        }

        return $resolvedProperty;
    }

    /**
     * Populate a entity from an array of data
     *
     * @param mixed[] $data The data to fill the entity with
     *
     * @return void
     */
    public function fill(array $data): void
    {
        if ($this instanceof PrePopulateInterface) {
            $this->beforeFill();
        }

        // Loop through data and set values, set will automatically skip invalid or non-fillable properties
        foreach ($data as $property => $value) {
            $this->set($property, $value);
        }
    }

    /**
     * Generate unique id.
     *
     * @param string $prefix
     * @param null|bool $moreEntropy
     *
     * @return string
     */
    protected function generateId(string $prefix, ?bool $moreEntropy = null): string
    {
        return \uniqid($prefix, $moreEntropy ?? false);
    }

    /**
     * Get property value.
     *
     * @param string $property
     *
     * @return mixed
     */
    private function get(string $property)
    {
        return $this->{$property};
    }

    /**
     * Get property value as boolean.
     *
     * @param string $property
     *
     * @return bool
     */
    private function is(string $property): bool
    {
        return (bool)$this->get($property);
    }

    /**
     * Set property.
     *
     * @param string $property
     * @param $value
     *
     * @return \PostmanGenerator\Schemas\AbstractSchema
     */
    private function set(string $property, $value): self
    {
        $property = \str_replace('_', ' ', $property);

        $pascalProperty = \str_replace(' ', '', \ucwords($property));

        $method = \sprintf('set%s', $pascalProperty);

        if (\method_exists($this, $method) === true) {
            $this->{$method}($value);
        }

        $this->{\lcfirst($pascalProperty)} = $value;

        return $this;
    }
}
