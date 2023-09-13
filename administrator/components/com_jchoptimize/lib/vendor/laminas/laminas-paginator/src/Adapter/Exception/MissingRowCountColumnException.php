<?php

namespace _JchOptimizeVendor\Laminas\Paginator\Adapter\Exception;

class MissingRowCountColumnException extends \LogicException implements ExceptionInterface
{
    /**
     * @param string $columnName name of row count column
     *
     * @return self
     */
    public static function forColumn($columnName)
    {
        return new self(\sprintf('Unable to determine row count; missing row count column ("%s") in result', $columnName));
    }
}
