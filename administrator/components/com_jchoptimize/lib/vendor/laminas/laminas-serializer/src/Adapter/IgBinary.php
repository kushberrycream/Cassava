<?php

/**
 * @see https://github.com/laminas/laminas-serializer for the canonical source repository
 */
declare(strict_types=1);

namespace _JchOptimizeVendor\Laminas\Serializer\Adapter;

use _JchOptimizeVendor\Laminas\Serializer\Exception;
use _JchOptimizeVendor\Laminas\Stdlib\ErrorHandler;

class IgBinary extends AbstractAdapter
{
    /** @var string Serialized null value */
    private static $serializedNull;

    /**
     * @param AdapterOptions|array|\Traversable $options
     *
     * @throws Exception\ExtensionNotLoadedException if igbinary extension is not present
     */
    public function __construct($options = null)
    {
        if (!\extension_loaded('igbinary')) {
            throw new Exception\ExtensionNotLoadedException('PHP extension "igbinary" is required for this adapter');
        }
        if (null === static::$serializedNull) {
            static::$serializedNull = \igbinary_serialize(null);
        }
        parent::__construct($options);
    }

    /**
     * Serialize PHP value to igbinary.
     *
     * @param mixed $value
     *
     * @return string
     *
     * @throws Exception\RuntimeException on igbinary error
     */
    public function serialize($value)
    {
        ErrorHandler::start();
        $ret = \igbinary_serialize($value);
        $err = ErrorHandler::stop();
        if (\false === $ret) {
            throw new Exception\RuntimeException('Serialization failed', 0, $err);
        }

        return $ret;
    }

    /**
     * Deserialize igbinary string to PHP value.
     *
     * @param string $serialized
     *
     * @return mixed
     *
     * @throws Exception\RuntimeException on igbinary error
     */
    public function unserialize($serialized)
    {
        if ($serialized === static::$serializedNull) {
            return;
        }
        ErrorHandler::start();
        $ret = \igbinary_unserialize($serialized);
        $err = ErrorHandler::stop();
        if (null === $ret) {
            throw new Exception\RuntimeException('Unserialization failed', 0, $err);
        }

        return $ret;
    }
}
