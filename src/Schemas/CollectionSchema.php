<?php
declare(strict_types=1);

namespace PostmanGenerator\Schemas;

use PostmanGenerator\Interfaces\CollectionSchemaInterface;

/**
 * @method null|InfoSchema getInfo()
 * @method null|AuthSchema getAuth()
 * @method VariableSchema[] getVariable()
 * @method self setInfo(InfoSchema $info)
 * @method self setAuth(AuthSchema $auth)
 * @method self setVariable(VariableSchema $variable)
 */
class CollectionSchema extends AbstractItemableSchema
{
    /** @var \PostmanGenerator\Schemas\AuthSchema */
    protected $auth;

    /** @var \PostmanGenerator\Schemas\InfoSchema */
    protected $info;

    /** @var \PostmanGenerator\Schemas\VariableSchema[] */
    protected $variable = [];

    /**
     * Add Collection item.
     *
     * @param \PostmanGenerator\Interfaces\CollectionSchemaInterface $item
     *
     * @return \PostmanGenerator\Schemas\CollectionSchema
     */
    public function addItem(CollectionSchemaInterface $item): AbstractItemableSchema
    {
        if ($item instanceof CollectionItemSchema) {
            /** @var null|\PostmanGenerator\Schemas\CollectionItemSchema $existingItem */
            $existingItem = $this->getItemByName($item->getName());

            if ($existingItem !== null) {
                // Merge items to existing collection item in collection.
                $existingItem->addItems($item->getItem());

                return $this;
            }

            $this->item[] = $item;
        }

        return $this;
    }

    /**
     * Add variable item.
     *
     * @param \PostmanGenerator\Schemas\VariableSchema $variable
     *
     * @return \PostmanGenerator\Schemas\CollectionSchema
     */
    public function addVariable(VariableSchema $variable): self
    {
        $this->variable[] = $variable;

        return $this;
    }

    /**
     * Serialize object as array.
     *
     * @return mixed[]
     */
    public function toArray(): array
    {
        return [
            'info' => $this->getInfo(),
            'item' => $this->getItem(),
            'auth' => $this->getAuth(),
            'variable' => $this->getVariable()
        ];
    }
}
