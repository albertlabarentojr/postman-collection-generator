<?php
declare(strict_types=1);

namespace PostmanGenerator;

use PostmanGenerator\Interfaces\CollectionInterface;
use PostmanGenerator\Interfaces\CollectionRequestInterface;
use PostmanGenerator\Interfaces\ItemableCollectionInterface;
use PostmanGenerator\Interfaces\RequestExampleInterface;
use PostmanGenerator\Interfaces\RequestParserInterface;
use PostmanGenerator\Schemas\CollectionItemSchema;
use PostmanGenerator\Schemas\CollectionSubItemSchema;
use PostmanGenerator\Schemas\DescriptionSchema;
use PostmanGenerator\Schemas\ItemSchema;
use PostmanGenerator\Schemas\RequestSchema;

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

    /**
     * Get collection description.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->collectionItem->getDescription();
    }

    /**
     * Set request description.
     *
     * @param \PostmanGenerator\Schemas\DescriptionSchema $description
     *
     * @return \PostmanGenerator\Interfaces\CollectionInterface
     */
    public function setDescription(DescriptionSchema $description): CollectionInterface
    {
        $this->collectionItem->setDescription($description->getContent());

        return $this;
    }

    /**
     * Add collection request.
     *
     * @param string $exampleName
     * @param \PostmanGenerator\Interfaces\RequestParserInterface $request
     *
     * @return \PostmanGenerator\Interfaces\RequestExampleInterface
     */
    public function addRequest(string $exampleName, RequestParserInterface $request): RequestExampleInterface
    {
        $item = new ItemSchema();
        $item->setName($exampleName);

        $this->collectionItem->addItem($item);

        return new RequestExample($item, $request);
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
}
