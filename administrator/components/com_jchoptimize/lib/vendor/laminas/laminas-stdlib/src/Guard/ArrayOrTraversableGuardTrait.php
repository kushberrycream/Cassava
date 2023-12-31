<?php

declare(strict_types=1);

namespace _JchOptimizeVendor\Laminas\Stdlib\Guard;

use _JchOptimizeVendor\Laminas\Stdlib\Exception\InvalidArgumentException;
use Exception;
use Traversable;

/**
 * Provide a guard method for array or Traversable data.
 */
trait ArrayOrTraversableGuardTrait
{
    /**
     * Verifies that the data is an array or Traversable.
     *
     * @param mixed  $data           the data to verify
     * @param string $dataName       the data name
     * @param string $exceptionClass FQCN for the exception
     *
     * @throws \Exception
     */
    protected function guardForArrayOrTraversable($data, $dataName = 'Argument', $exceptionClass = InvalidArgumentException::class)
    {
        if (!\is_array($data) && !$data instanceof \Traversable) {
            $message = \sprintf('%s must be an array or Traversable, [%s] given', $dataName, \is_object($data) ? \get_class($data) : \gettype($data));

            throw new $exceptionClass($message);
        }
    }
}
