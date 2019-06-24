<?php
declare(strict_types=1);

namespace PostmanGenerator\Schemas;

/**
 * @method null|\PostmanGenerator\Schemas\AuthSchema getAuth()
 * @method null|\PostmanGenerator\Schemas\InfoSchema getInfo()
 * @method \PostmanGenerator\Schemas\VariableSchema[] getVariable()
 * @method self setAuth(\PostmanGenerator\Schemas\AuthSchema $auth)
 * @method self setInfo(\PostmanGenerator\Schemas\InfoSchema $info)
 * @method self setVariable(\PostmanGenerator\Schemas\VariableSchema $variable)
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
