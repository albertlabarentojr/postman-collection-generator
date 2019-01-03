<?php
declare(strict_types=1);

namespace Tests\App;

use PostmanGenerator\Interfaces\Serializable;

class SerializableStub implements Serializable
{
    /**
     * Serialize object as array.
     *
     * @return mixed[]
     */
    public function toArray(): array
    {
        return [
            'parent_name' => 'Mr. Joe',
            'address' => 'Makati',
            'child' => $this->getChild()
        ];
    }

    /**
     * Serializable child stub.
     *
     * @return \PostmanGenerator\Interfaces\Serializable
     */
    private function getChild(): Serializable
    {
        return new class() implements Serializable
        {
            /**
             * Serialize object as array.
             *
             * @return mixed[]
             */
            public function toArray(): array
            {
                return [
                    'child_name' => 'Joe Jr.',
                    'address' => 'San antonio',
                    'child' => $this->getGrandChild(),
                    'children' => [$this->getGrandChild(), $this->getGrandChild()]
                ];
            }

            /**
             * Serializable grandchild stub.
             *
             * @return \PostmanGenerator\Interfaces\Serializable
             */
            private function getGrandChild(): Serializable
            {
                return new class() implements Serializable
                {
                    /**
                     * Serialize object as array.
                     *
                     * @return mixed[]
                     */
                    public function toArray(): array
                    {
                        return [
                            'grand_child_name' => 'Joe III',
                            'address' => 'Sarmiento Condominium',
                            'child' => null
                        ];
                    }
                };
            }
        };
    }
}
