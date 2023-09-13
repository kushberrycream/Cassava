<?php

/**
 * @copyright Copyright (c)2010-2021 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   GNU General Public License version 2, or later
 */

namespace JchOptimize\Helper;

use _JchOptimizeVendor\Joomla\DI\Exception\KeyNotFoundException;
use JConfig;
use Joomla\Application\AbstractApplication;
use Joomla\Application\ConfigurationAwareApplicationInterface;
use Joomla\CMS\Cache\Cache;
use Joomla\CMS\Cache\CacheControllerFactoryInterface;
use Joomla\CMS\Cache\Controller\CallbackController;
use Joomla\CMS\Factory;
use Joomla\Registry\Registry;

use function defined;

\defined('_JEXEC') or exit('Restricted Access');

/**
 * A utility class to help you quickly clean the Joomla! cache, borrowed and modified a bit from FOF40.
 *
 * @psalm-suppress all
 */
class CacheCleaner
{
    /**
     * Clears the com_modules and com_plugins cache. You need to call this whenever you alter the publish state or
     * parameters of a module or plugin from your code.
     */
    public static function clearPluginsAndModulesCache()
    {
        self::clearPluginsCache();
        self::clearModulesCache();
    }

    /**
     * Clears the com_plugins cache. You need to call this whenever you alter the publish state or parameters of a
     * plugin from your code.
     *
     * @throws \Exception
     */
    public static function clearPluginsCache()
    {
        self::clearCacheGroups(['com_plugins'], [0, 1]);
    }

    /**
     * Clears the specified cache groups.
     *
     * @param array       $clearGroups  Which cache groups to clear. Usually this is com_yourcomponent to clear
     *                                  your component's cache.
     * @param array       $cacheClients Which cache clients to clear. 0 is the back-end, 1 is the front-end. If you
     *                                  do not specify anything, both cache clients will be cleared.
     * @param null|string $event        An event to run upon trying to clear the cache. Empty string to disable. If
     *                                  NULL and the group is "com_content" I will trigger onContentCleanCache.
     *
     * @throws \Exception
     */
    public static function clearCacheGroups(array $clearGroups, array $cacheClients = [0, 1], ?string $event = null): void
    {
        // Early return on nonsensical input
        if (empty($clearGroups) || empty($cacheClients)) {
            return;
        }
        // Make sure I have an application object
        try {
            $app = Factory::getApplication();
        } catch (\Exception $e) {
            return;
        }
        // If there's no application object things will break; let's get outta here.
        if (!\is_object($app)) {
            return;
        }
        $isJoomla4 = \version_compare(JVERSION, '3.9999.9999', 'gt');
        // Loop all groups to clean
        foreach ($clearGroups as $group) {
            // Groups must be non-empty strings
            if (empty($group) || !\is_string($group)) {
                continue;
            }
            // Loop all clients (applications)
            foreach ($cacheClients as $client_id) {
                $client_id = (int) ($client_id ?? 0);
                $options = $isJoomla4 ? self::clearCacheGroupJoomla4($group, $client_id, $app) : self::clearCacheGroupJoomla3($group, $client_id, $app);
            }
        }
    }

    /**
     * Clears the com_modules cache. You need to call this whenever you alter the publish state or parameters of a
     * module from your code.
     */
    public static function clearModulesCache()
    {
        self::clearCacheGroups(['com_modules'], [0, 1]);
    }

    /**
     * Clean a cache group on Joomla 4.
     *
     * @param string $group     The cache to clean, e.g. com_content
     * @param int    $client_id The application ID for which the cache will be cleaned
     * @param object $app       The current CMS application. DO NOT TYPEHINT MORE SPECIFICALLY!
     *
     * @return array Cache controller options, including cleaning result
     *
     * @throws \Exception
     */
    private static function clearCacheGroupJoomla4(string $group, int $client_id, object $app): array
    {
        // Get the default cache folder. Start by using the JPATH_CACHE constant.
        $cacheBaseDefault = JPATH_CACHE;
        $appClientId = 0;
        if (\method_exists($app, 'getClientId')) {
            $appClientId = $app->getClientId();
        }
        // -- If we are asked to clean cache on the other side of the application we need to find a new cache base
        if ($client_id != $appClientId) {
            $cacheBaseDefault = ($client_id ? JPATH_SITE : JPATH_ADMINISTRATOR).'/cache';
        }
        // Get the cache controller's options
        $options = ['defaultgroup' => $group, 'cachebase' => self::getAppConfigParam($app, 'cache_path', $cacheBaseDefault), 'result' => \true];

        try {
            $container = Factory::getContainer();

            try {
                /** @var CacheControllerFactoryInterface $cacheControllerFactory */
                $cacheControllerFactory = $container->get('cache.controller.factory');
            } catch (KeyNotFoundException $e) {
                throw new \RuntimeException('Cannot get Joomla 4 cache controller factory');
            }

            try {
                /** @var CallbackController $cache */
                $cache = $cacheControllerFactory->createCacheController('callback', $options);
                if (!\property_exists($cache, 'cache') || !\method_exists($cache->cache, 'clean')) {
                    throw new \RuntimeException('Cache controller not valid');
                }
            } catch (KeyNotFoundException|\RuntimeException $e) {
                throw new \RuntimeException('Cannot get Joomla 4 cache controller');
            }
            $cache->cache->clean();
        } catch (\Exception|\Throwable $exception) {
            $options['result'] = \false;
        }

        return $options;
    }

    /**
     * @return null|mixed|\stdClass|string
     */
    private static function getAppConfigParam(?object $app, string $key, ?string $default = null)
    {
        /*
         * Any kind of Joomla CMS, Web, API or CLI application extends from AbstractApplication and has the get()
         * method to return application configuration parameters.
         */
        if (\is_object($app) && $app instanceof AbstractApplication) {
            return $app->get($key, $default);
        }
        /*
         * A custom application may instead implement the Joomla\Application\ConfigurationAwareApplicationInterface
         * interface (Joomla 4+), in whihc case it has the get() method to return application configuration parameters.
         */
        if (\is_object($app) && \interface_exists('Joomla\\Application\\ConfigurationAwareApplicationInterface', \true) && $app instanceof ConfigurationAwareApplicationInterface) {
            return $app->get($key, $default);
        }
        // A Joomla 3 custom application may simply implement the get() method without implementing an interface.
        if (\is_object($app) && \method_exists($app, 'get')) {
            return $app->get($key, $default);
        }
        /*
         * At this point the $app variable is not an object or is something I can't use. Does the Joomla Factory still
         * has the legacy static method getConfig() to get the application configuration? If so, use it.
         */
        if (\method_exists(Factory::class, 'getConfig')) {
            try {
                $jConfig = Factory::getConfig();
                if (\is_object($jConfig) && $jConfig instanceof Registry) {
                    $jConfig->get($key, $default);
                }
            } catch (\Throwable $e) {
                /*
                 * Factory tries to go through the application object. It might fail if there is a custom application
                 * which doesn't implement the interfaces Factory expects. In this case we get a Fatal Error whcih we
                 * can trap and fall through to the next if-block.
                 */
            }
        }

        /**
         * When we are here all hope is nearly lost. We have to do a crude approximation of Joomla Factory's code to
         * create an application configuration Registry object and retrieve the configuration values. This will work as
         * long as the JConfig class (defined in configuration.php) has been loaded.
         */
        $configPath = \defined('JPATH_CONFIGURATION') ? JPATH_CONFIGURATION : (\defined('JPATH_ROOT') ? JPATH_ROOT : null);
        $configPath = $configPath ?? __DIR__.'/../../..';
        $configFile = $configPath.'/configuration.php';
        if (!\class_exists('JConfig') && @\file_exists($configFile) && @\is_file($configFile) && @\is_readable($configFile)) {
            require_once $configFile;
        }
        if (\class_exists('JConfig')) {
            try {
                $jConfig = new Registry();
                $configObject = new \JConfig();
                $jConfig->loadObject($configObject);

                return $jConfig->get($key, $default);
            } catch (\Throwable $e) {
                return $default;
            }
        }
        /*
         * All hope is lost. I can't find the application configuration. I am returning the default value and hope stuff
         * won't break spectacularly...
         */
        return $default;
    }

    /**
     * Clean a cache group on Joomla 3.
     *
     * @param string $group     The cache to clean, e.g. com_content
     * @param int    $client_id The application ID for which the cache will be cleaned
     * @param object $app       The current CMS application. DO NOT TYPEHINT MORE SPECIFICALLY!
     *
     * @return array Cache controller options, including cleaning result
     *
     * @throws \Exception
     */
    private static function clearCacheGroupJoomla3(string $group, int $client_id, object $app): array
    {
        $options = ['defaultgroup' => $group, 'cachebase' => $client_id ? JPATH_ADMINISTRATOR.'/cache' : self::getAppConfigParam($app, 'cache_path', JPATH_SITE.'/cache'), 'result' => \true];

        try {
            $cache = Cache::getInstance('callback', $options);
            // @noinspection PhpUndefinedMethodInspection Available via __call(), not tagged in Joomla core
            $cache->clean();
        } catch (\Throwable $e) {
            $options['result'] = \false;
        }

        return $options;
    }
}
