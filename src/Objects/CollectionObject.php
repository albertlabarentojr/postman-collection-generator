<?php
declare(strict_types=1);

namespace PostmanGenerator\Objects;

use PostmanGenerator\Interfaces\CollectionObjectInterface;

/**
 * @method null|InfoObject getInfo()
 * @method null|AuthObject getAuth()
 * @method VariableObject[] getVariable()
 * @method self setInfo(InfoObject $info)
 * @method self setAuth(AuthObject $auth)
 * @method self setVariable(VariableObject $variable)
 */
class CollectionObject extends AbstractItemableObject
{
    /** @var \PostmanGenerator\Objects\AuthObject */
    protected $auth;

    /** @var \PostmanGenerator\Objects\InfoObject */
    protected $info;

    /** @var \PostmanGenerator\Objects\VariableObject[] */
    protected $variable = [];

    /**
     * Add Collection item.
     *
     * @param \PostmanGenerator\Interfaces\CollectionObjectInterface $item
     *
     * @return \PostmanGenerator\Objects\CollectionObject
     */
    public function addItem(CollectionObjectInterface $item): AbstractItemableObject
    {
        if ($item instanceof CollectionItemObject) {
            /** @var null|\PostmanGenerator\Objects\CollectionItemObject $existingItem */
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
     * @param \PostmanGenerator\Objects\VariableObject $variable
     *
     * @return \PostmanGenerator\Objects\CollectionObject
     */
    public function addVariable(VariableObject $variable): self
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
