<?php

declare(strict_types=1);

namespace _JchOptimizeVendor\Laminas\Stdlib;

interface ArraySerializableInterface
{
    /**
     * Exchange internal values from provided array.
     */
    public function exchangeArray(array $array);

    /**
     * Return an array representation of the object.
     *
     * @return array
     */
    public function getArrayCopy();
}
