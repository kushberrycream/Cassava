<?php

namespace _JchOptimizeVendor\Illuminate\Container;

use _JchOptimizeVendor\Illuminate\Contracts\Container\Container;
use _JchOptimizeVendor\Illuminate\Contracts\Container\ContextualBindingBuilder as ContextualBindingBuilderContract;

class ContextualBindingBuilder implements ContextualBindingBuilderContract
{
    /**
     * The underlying container instance.
     *
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $container;

    /**
     * The concrete instance.
     *
     * @var array|string
     */
    protected $concrete;

    /**
     * The abstract target.
     *
     * @var string
     */
    protected $needs;

    /**
     * Create a new contextual binding builder.
     *
     * @param \Illuminate\Contracts\Container\Container $container
     * @param array|string                              $concrete
     */
    public function __construct(Container $container, $concrete)
    {
        $this->concrete = $concrete;
        $this->container = $container;
    }

    /**
     * Define the abstract target that depends on the context.
     *
     * @param string $abstract
     *
     * @return $this
     */
    public function needs($abstract)
    {
        $this->needs = $abstract;

        return $this;
    }

    /**
     * Define the implementation for the contextual binding.
     *
     * @param array|\Closure|string $implementation
     */
    public function give($implementation)
    {
        foreach (Util::arrayWrap($this->concrete) as $concrete) {
            $this->container->addContextualBinding($concrete, $this->needs, $implementation);
        }
    }

    /**
     * Define tagged services to be used as the implementation for the contextual binding.
     *
     * @param string $tag
     */
    public function giveTagged($tag)
    {
        $this->give(function ($container) use ($tag) {
            $taggedServices = $container->tagged($tag);

            return \is_array($taggedServices) ? $taggedServices : \iterator_to_array($taggedServices);
        });
    }

    /**
     * Specify the configuration item to bind as a primitive.
     *
     * @param string  $key
     * @param ?string $default
     */
    public function giveConfig($key, $default = null)
    {
        $this->give(function ($container) use ($key, $default) {
            return $container->get('config')->get($key, $default);
        });
    }
}
