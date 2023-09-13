<?php

declare(strict_types=1);

namespace _JchOptimizeVendor\Laminas\Stdlib;

use ReturnTypeWillChange;
use Serializable;

use function serialize;
use function unserialize;

/**
 * Serializable version of SplStack.
 *
 * @template TValue
 *
 * @extends \SplStack<TValue>
 */
class SplStack extends \SplStack implements \Serializable
{
    /**
     * Magic method used for serializing of an instance.
     *
     * @return list<TValue>
     */
    #[\ReturnTypeWillChange]
    public function __serialize()
    {
        return $this->toArray();
    }

    /**
     * Magic method used to rebuild an instance.
     *
     * @param array<array-key, TValue> $data data array
     */
    #[\ReturnTypeWillChange]
    public function __unserialize($data)
    {
        foreach ($data as $item) {
            $this->unshift($item);
        }
    }

    /**
     * Serialize to an array representing the stack.
     *
     * @return list<TValue>
     */
    public function toArray()
    {
        $array = [];
        foreach ($this as $item) {
            $array[] = $item;
        }

        return $array;
    }

    /**
     * Serialize.
     *
     * @return string
     */
    #[\ReturnTypeWillChange]
    public function serialize()
    {
        return \serialize($this->__serialize());
    }

    /**
     * Unserialize.
     *
     * @param string $data
     */
    #[\ReturnTypeWillChange]
    public function unserialize($data)
    {
        $toUnserialize = \unserialize($data);
        if (!\is_array($toUnserialize)) {
            throw new \UnexpectedValueException(\sprintf('Cannot deserialize %s instance; corrupt serialization data', self::class));
        }
        $this->__unserialize($toUnserialize);
    }
}
