<?php
declare(strict_types=1);

namespace PostmanGenerator;

use PostmanGenerator\Interfaces\CollectionInterface;
use PostmanGenerator\Interfaces\ItemableCollectionInterface;
use PostmanGenerator\Interfaces\RequestExampleInterface;
use PostmanGenerator\Interfaces\RequestParserInterface;
use PostmanGenerator\Schemas\CollectionSubItemSchema;
use PostmanGenerator\Schemas\ItemSchema;

class Collection implements CollectionInterface
{
    /**
     * @var \PostmanGenerator\Schemas\CollectionItemSchema
     */
    private $collectionItem;

    /**
     * Collection constructor.
     *
     * @param \PostmanGenerator\Interfaces\ItemableCollectionInterface $collectionItem
     */
    public function __construct(ItemableCollectionInterface $collectionItem)
    {
        $this->collectionItem = $collectionItem;
    }

    /**
     * Add configuration to collection object
     *
     * @param array $config
     *
     * @return void
     */
    public function addConfig(array $config): void
    {
        $this->collectionItem->fill($config);
    }

    /**
     * Add collection request.
     *
     * @param string $requestName
     * @param \PostmanGenerator\Interfaces\RequestParserInterface $request
     *
     * @return \PostmanGenerator\Interfaces\RequestExampleInterface
     */
    public function addRequest(string $requestName, RequestParserInterface $request): RequestExampleInterface
    {
        $item = new ItemSchema();
        $item->setName($requestName);

        $this->collectionItem->addItem($item);

        return new RequestExample($item, $request);
    }

    /**
     * Add collection request.
     *
     * @param string $requestName
     *
     * @return \PostmanGenerator\Interfaces\CollectionInterface
     */
    public function addSubCollection(string $requestName): CollectionInterface
    {
        $collectionSubItem = new CollectionSubItemSchema();
        $collectionSubItem->setName($requestName);

        $this->collectionItem->addItem($collectionSubItem);

        return new self($collectionSubItem);
    }
}
