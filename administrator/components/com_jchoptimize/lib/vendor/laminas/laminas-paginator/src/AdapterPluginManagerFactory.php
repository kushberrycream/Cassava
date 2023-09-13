<?php

namespace _JchOptimizeVendor\Laminas\Paginator;

use _JchOptimizeVendor\Interop\Container\ContainerInterface;
use _JchOptimizeVendor\Laminas\ServiceManager\Config;
use _JchOptimizeVendor\Laminas\ServiceManager\FactoryInterface;
use _JchOptimizeVendor\Laminas\ServiceManager\ServiceLocatorInterface;

class AdapterPluginManagerFactory implements FactoryInterface
{
    /**
     * laminas-servicemanager v2 support for invocation options.
     *
     * @var array
     */
    protected $creationOptions;

    /**
     * @return AdapterPluginManager
     */
    public function __invoke(ContainerInterface $container, $name, ?array $options = null)
    {
        $pluginManager = new AdapterPluginManager($container, $options ?: []);
        // If we do not have a config service, nothing more to do
        if (!$container->has('config')) {
            return $pluginManager;
        }
        $config = $container->get('config')['paginators'] ?? null;
        // If we do not have serializers configuration, nothing more to do
        if (!\is_array($config)) {
            return $pluginManager;
        }
        // Wire service configuration for serializers
        (new Config($config))->configureServiceManager($pluginManager);

        return $pluginManager;
    }

    /**
     * @return AdapterPluginManager
     */
    public function createService(ServiceLocatorInterface $container, $name = null, $requestedName = null)
    {
        return $this($container, $requestedName ?: AdapterPluginManager::class, $this->creationOptions);
    }

    /**
     * laminas-servicemanager v2 support for invocation options.
     */
    public function setCreationOptions(array $options)
    {
        $this->creationOptions = $options;
    }
}
