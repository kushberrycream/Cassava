<?php

/**
 * @see https://github.com/laminas/laminas-serializer for the canonical source repository
 */
declare(strict_types=1);

namespace _JchOptimizeVendor\Laminas\Serializer\Adapter;

use _JchOptimizeVendor\Laminas\Serializer\Exception;
use _JchOptimizeVendor\Laminas\Stdlib\ErrorHandler;

use function serialize;
use function unserialize;

class PhpSerialize extends AbstractAdapter
{
    /** @var PhpSerializeOptions */
    protected $options;

    /**
     * Serialized boolean false value.
     *
     * @var null|string
     */
    private static $serializedFalse;

    /**
     * Constructor.
     *
     * @param null|array|PhpSerializeOptions|\Traversable $options
     */
    public function __construct($options = null)
    {
        // needed to check if a returned false is based on a serialize false
        // or based on failure (igbinary can overwrite [un]serialize functions)
        if (null === static::$serializedFalse) {
            static::$serializedFalse = \serialize(\false);
        }
        parent::__construct($options);
    }

    /**
     * Set options.
     *
     * @param array|PhpSerializeOptions|\Traversable $options
     *
     * @return PhpSerialize
     */
    public function setOptions($options)
    {
        if (!$options instanceof PhpSerializeOptions) {
            $options = new PhpSerializeOptions($options);
        }
        $this->options = $options;

        return $this;
    }

    /**
     * Get options.
     *
     * @return PhpSerializeOptions
     */
    public function getOptions()
    {
        if (null === $this->options) {
            $this->options = new PhpSerializeOptions();
        }

        return $this->options;
    }

    /**
     * Serialize using serialize().
     *
     * @param mixed $value
     *
     * @return string
     *
     * @throws Exception\RuntimeException on serialize error
     */
    public function serialize($value)
    {
        ErrorHandler::start();
        $ret = \serialize($value);
        $err = ErrorHandler::stop();
        if ($err) {
            throw new Exception\RuntimeException('Serialization failed', 0, $err);
        }

        return $ret;
    }

    /**
     * Unserialize.
     *
     * @todo   Allow integration with unserialize_callback_func
     *
     * @param string $serialized
     *
     * @return mixed
     *
     * @throws Exception\RuntimeException on unserialize error
     */
    public function unserialize($serialized)
    {
        if (!\is_string($serialized) || !\preg_match('/^((s|i|d|b|a|O|C):|N;)/', $serialized)) {
            $value = $serialized;
            if (\is_object($value)) {
                $value = \get_class($value);
            } elseif (!\is_string($value)) {
                $value = \gettype($value);
            }

            throw new Exception\RuntimeException(\sprintf('Serialized data must be a string containing serialized PHP code; received: %s', $value));
        }
        // If we have a serialized boolean false value, just return false;
        // prevents the unserialize handler from creating an error.
        if ($serialized === static::$serializedFalse) {
            return \false;
        }
        ErrorHandler::start(\E_NOTICE);
        // The second parameter to unserialize() is only available on PHP 7.0 or higher
        $ret = \PHP_MAJOR_VERSION >= 7 ? \unserialize($serialized, ['allowed_classes' => $this->getOptions()->getUnserializeClassWhitelist()]) : \unserialize($serialized);
        $err = ErrorHandler::stop();
        if (\false === $ret) {
            throw new Exception\RuntimeException('Unserialization failed', 0, $err);
        }

        return $ret;
    }
}
