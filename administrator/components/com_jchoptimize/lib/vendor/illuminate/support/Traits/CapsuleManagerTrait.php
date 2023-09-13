<?php

namespace _JchOptimizeVendor\Illuminate\Support\Traits;

use _JchOptimizeVendor\Illuminate\Contracts\Container\Container;
use _JchOptimizeVendor\Illuminate\Support\Fluent;

trait CapsuleManagerTrait
{
    /**
     * The current globally used instance.
     *
     * @var object
     */
    protected static $instance;

    /**
     * The container instance.
     *
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $container;

    /**
     * Make this capsule instance available globally.
     */
    public function setAsGlobal()
    {
        static::$instance = $this;
    }

    /**
     * Get the IoC container instance.
     *
     * @return \Illuminate\Contracts\Container\Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Set the IoC container instance.
     *
     * @param \Illuminate\Contracts\Container\Container $container
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Setup the IoC container instance.
     *
     * @param \Illuminate\Contracts\Container\Container $container
     */
    protected function setupContainer(Container $container)
    {
        $this->container = $container;
        if (!$this->container->bound('config')) {
            $this->container->instance('config', new Fluent());
        }
    }
}
