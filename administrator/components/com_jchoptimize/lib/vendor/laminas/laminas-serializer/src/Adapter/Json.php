<?php

/**
 * @see https://github.com/laminas/laminas-serializer for the canonical source repository
 */
declare(strict_types=1);

namespace _JchOptimizeVendor\Laminas\Serializer\Adapter;

use _JchOptimizeVendor\Laminas\Json\Json as LaminasJson;
use _JchOptimizeVendor\Laminas\Serializer\Exception;

class Json extends AbstractAdapter
{
    /** @var JsonOptions */
    protected $options;

    /**
     * Set options.
     *
     * @param array|JsonOptions|\Traversable $options
     *
     * @return Json
     */
    public function setOptions($options)
    {
        if (!$options instanceof JsonOptions) {
            $options = new JsonOptions($options);
        }
        $this->options = $options;

        return $this;
    }

    /**
     * Get options.
     *
     * @return JsonOptions
     */
    public function getOptions()
    {
        if (null === $this->options) {
            $this->options = new JsonOptions();
        }

        return $this->options;
    }

    /**
     * Serialize PHP value to JSON.
     *
     * @param mixed $value
     *
     * @return string
     *
     * @throws Exception\InvalidArgumentException
     * @throws Exception\RuntimeException
     */
    public function serialize($value)
    {
        $options = $this->getOptions();
        $cycleCheck = $options->getCycleCheck();
        $opts = ['enableJsonExprFinder' => $options->getEnableJsonExprFinder(), 'objectDecodeType' => $options->getObjectDecodeType()];

        try {
            return LaminasJson::encode($value, $cycleCheck, $opts);
        } catch (\InvalidArgumentException $e) {
            throw new Exception\InvalidArgumentException('Serialization failed: '.$e->getMessage(), 0, $e);
        } catch (\Exception $e) {
            throw new Exception\RuntimeException('Serialization failed: '.$e->getMessage(), 0, $e);
        }
    }

    /**
     * Deserialize JSON to PHP value.
     *
     * @param string $json
     *
     * @return mixed
     *
     * @throws Exception\InvalidArgumentException
     * @throws Exception\RuntimeException
     */
    public function unserialize($json)
    {
        try {
            $ret = LaminasJson::decode($json, $this->getOptions()->getObjectDecodeType());
        } catch (\InvalidArgumentException $e) {
            throw new Exception\InvalidArgumentException('Unserialization failed: '.$e->getMessage(), 0, $e);
        } catch (\Exception $e) {
            throw new Exception\RuntimeException('Unserialization failed: '.$e->getMessage(), 0, $e);
        }

        return $ret;
    }
}
