<?php

namespace _JchOptimizeVendor\Laminas\Cache\Storage;

use _JchOptimizeVendor\Laminas\EventManager\EventsCapableInterface;

interface PluginCapableInterface extends EventsCapableInterface
{
    /**
     * Check if a plugin is registered.
     *
     * @return bool
     */
    public function hasPlugin(Plugin\PluginInterface $plugin);

    /**
     * Return registry of plugins.
     *
     * @return \SplObjectStorage
     */
    public function getPluginRegistry();
}
