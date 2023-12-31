<?php

namespace _JchOptimizeVendor\Laminas\Cache\Pattern;

abstract class AbstractPattern implements PatternInterface
{
    /** @var null|PatternOptions */
    protected $options;

    public function __construct(?PatternOptions $options = null)
    {
        $this->options = $options;
    }

    /**
     * @return AbstractPattern
     */
    public function setOptions(PatternOptions $options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return PatternOptions
     */
    public function getOptions()
    {
        if (null === $this->options) {
            $this->setOptions(new PatternOptions());
        }

        return $this->options;
    }
}
