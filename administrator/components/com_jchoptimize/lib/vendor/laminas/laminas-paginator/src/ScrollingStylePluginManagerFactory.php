<?php

namespace _JchOptimizeVendor\Laminas\Paginator;

use _JchOptimizeVendor\Interop\Container\ContainerInterface;
use _JchOptimizeVendor\Laminas\ServiceManager\FactoryInterface;
use _JchOptimizeVendor\Laminas\ServiceManager\ServiceLocatorInterface;

class ScrollingStylePluginManagerFactory implements FactoryInterface
{
    /**
     * laminas-servicemanager v2 support for invocation options.
     *
     * @var array
     */
    protected $creationOptions;

    /**
     * @return ScrollingStylePluginManager
     */
    public function __invoke(ContainerInterface $container, $name, ?array $options = null)
    {
        return new ScrollingStylePluginManager($container, $options ?: []);
    }

    /**
     * @return ScrollingStylePluginManager
     */
    public function createService(ServiceLocatorInterface $container, $name = null, $requestedName = null)
    {
        return $this($container, $requestedName ?: ScrollingStylePluginManager::class, $this->creationOptions);
    }

    /**
     * laminas-servicemanager v2 support for invocation options.
     */
    public function setCreationOptions(array $options)
    {
        $this->creationOptions = $options;
    }
}
