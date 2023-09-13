<?php

/**
 * JCH Optimize - Performs several front-end optimizations for fast downloads.
 *
 * @author    Samuel Marshall <samuel@jch-optimize.net>
 * @copyright Copyright (c) 2022 Samuel Marshall / JCH Optimize
 * @license   GNU/GPLv3, or later. See LICENSE file
 *
 *  If LICENSE file missing, see <http://www.gnu.org/licenses/>.
 */

namespace JchOptimize\Core\Service;

use _JchOptimizeVendor\Joomla\DI\Container;
use _JchOptimizeVendor\Joomla\DI\ServiceProviderInterface;
use _JchOptimizeVendor\Laminas\Cache\Pattern\CallbackCache;
use _JchOptimizeVendor\Laminas\Cache\Pattern\CaptureCache;
use _JchOptimizeVendor\Laminas\Cache\Pattern\PatternOptions;
use _JchOptimizeVendor\Laminas\Cache\Service\StorageAdapterFactory;
use _JchOptimizeVendor\Laminas\Cache\Service\StorageAdapterFactoryInterface;
use _JchOptimizeVendor\Laminas\Cache\Service\StorageCacheAbstractServiceFactory;
use _JchOptimizeVendor\Laminas\Cache\Service\StoragePluginFactory;
use _JchOptimizeVendor\Laminas\Cache\Service\StoragePluginFactoryInterface;
use _JchOptimizeVendor\Laminas\Cache\Storage\Adapter\Apcu;
use _JchOptimizeVendor\Laminas\Cache\Storage\Adapter\Filesystem;
use _JchOptimizeVendor\Laminas\Cache\Storage\Adapter\Memcached;
use _JchOptimizeVendor\Laminas\Cache\Storage\Adapter\Redis;
use _JchOptimizeVendor\Laminas\Cache\Storage\Adapter\WinCache;
use _JchOptimizeVendor\Laminas\Cache\Storage\AdapterPluginManager;
use _JchOptimizeVendor\Laminas\Cache\Storage\IterableInterface;
use _JchOptimizeVendor\Laminas\Cache\Storage\PluginAwareInterface;
use _JchOptimizeVendor\Laminas\Cache\Storage\PluginManager;
use _JchOptimizeVendor\Laminas\Cache\Storage\StorageInterface;
use _JchOptimizeVendor\Laminas\Cache\Storage\TaggableInterface;
use _JchOptimizeVendor\Laminas\ServiceManager\PluginManagerInterface;
use JchOptimize\Core\Exception;
use JchOptimize\Core\Helper;
use JchOptimize\Core\Laminas\Plugins\ClearExpiredByFactor;
use JchOptimize\Platform\Cache;
use JchOptimize\Platform\Paths;
use JchOptimize\Platform\Utility;
use Joomla\Filesystem\File;
use Joomla\Registry\Registry;
use Psr\Log\LoggerInterface;

\defined('_JCH_EXEC') or exit('Restricted access');
class CachingProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container->alias(StorageAdapterFactoryInterface::class, StorageAdapterFactory::class)->share(StorageAdapterFactory::class, [$this, 'getStorageAdapterFactoryService'], \true);
        $container->alias(PluginManagerInterface::class, AdapterPluginManager::class)->share(AdapterPluginManager::class, [$this, 'getAdapterPluginManagerService'], \true);
        $container->alias(StoragePluginFactoryInterface::class, StoragePluginFactory::class)->share(StoragePluginFactory::class, [$this, 'getStoragePluginFactoryService'], \true);
        $container->share(PluginManager::class, [$this, 'getPluginManagerService'], \true);
        $container->share(StorageInterface::class, [$this, 'getStorageInterfaceService'], \true);
        $container->share(CallbackCache::class, [$this, 'getCallbackCacheService'], \true);
        $container->share(CaptureCache::class, [$this, 'getCaptureCacheService'], \true);
        $container->share('page_cache', [$this, 'getPageCacheStorageService'], \true);
        $container->alias('Filesystem', Filesystem::class)->share(Filesystem::class, [$this, 'getFilesystemService']);
        $container->alias('Redis', Redis::class)->share(Redis::class, [$this, 'getRedisService']);
        $container->alias('Apcu', Apcu::class)->share(Apcu::class, [$this, 'getApcuService']);
        $container->alias('Memcached', Memcached::class)->share(Memcached::class, [$this, 'getMemcachedService']);
        $container->alias('WinCache', WinCache::class)->share(WinCache::class, [$this, 'getWinCacheService']);
        $container->share(TaggableInterface::class, [$this, 'getTaggableInterfaceService'], \true);
    }

    public function getStorageAdapterFactoryService(Container $container): StorageAdapterFactoryInterface
    {
        return new StorageAdapterFactory($container->get(PluginManagerInterface::class), $container->get(StoragePluginFactoryInterface::class));
    }

    public function getAdapterPluginManagerService(Container $container): PluginManagerInterface
    {
        return new AdapterPluginManager($container, $container->get('config')['dependencies']);
    }

    /**
     * This will always fetch the Filesystem storage adapter.
     *
     * @throws Exception\RuntimeException
     */
    public function getFilesystemService(Container $container): StorageInterface
    {
        $fsCache = $this->getCacheAdapter($container, 'filesystem');
        $fsCache->getOptions()->setTtl(0);

        return $fsCache;
    }

    /**
     * @throws Exception\RuntimeException
     */
    public function getRedisService(Container $container): StorageInterface
    {
        $redisCache = $this->getCacheAdapter($container, 'redis');
        $redisCache->getOptions()->setTtl(0);

        return $redisCache;
    }

    /**
     * @throws Exception\RuntimeException
     */
    public function getApcuService(Container $container): StorageInterface
    {
        $apcuCache = $this->getCacheAdapter($container, 'apcu');
        $apcuCache->getOptions()->setTtl(0);

        return $apcuCache;
    }

    /**
     * @throws Exception\RuntimeException
     */
    public function getMemcachedService(Container $container): StorageInterface
    {
        $memcachedCache = $this->getCacheAdapter($container, 'memcached');
        $memcachedCache->getOptions()->setTtl(0);

        return $memcachedCache;
    }

    /**
     * @throws Exception\RuntimeException
     */
    public function getWinCacheService(Container $container): StorageInterface
    {
        $winCacheCache = $this->getCacheAdapter($container, 'wincache');
        $winCacheCache->getOptions()->setTtl(0);

        return $winCacheCache;
    }

    public function getStoragePluginFactoryService(Container $container): StoragePluginFactoryInterface
    {
        return new StoragePluginFactory($container->get(PluginManager::class));
    }

    public function getPluginManagerService(Container $container): PluginManagerInterface
    {
        return new PluginManager($container, $container->get('config')['dependencies']);
    }

    /**
     * This will get the storage adapter that is configured in the plugin parameters.
     *
     * @throws Exception\RuntimeException
     */
    public function getStorageInterfaceService(Container $container): StorageInterface
    {
        $params = $container->get(Registry::class);
        // Use whichever lifetime is greater to ensure page cache expires before
        $pageCacheTtl = (int) $params->get('page_cache_lifetime', '900');
        $globalTtl = (int) $params->get('cache_lifetime', '900');
        $lifetime = \max($pageCacheTtl, $globalTtl);
        $cache = $this->getCacheAdapter($container, $container->get(Registry::class)->get('pro_cache_storage_adapter', 'filesystem'));
        $cache->getOptions()->setNamespace(Cache::getCacheNamespace())->setTtl($lifetime);
        if ($cache instanceof PluginAwareInterface) {
            if ($params->get('delete_expiry', '1')) {
                $plugin = (new ClearExpiredByFactor())->setContainer($container);
                $plugin->setLogger($container->get(LoggerInterface::class));
                $plugin->getOptions()->setClearingFactor(50);
                $cache->addPlugin($plugin);
            }
        }

        return $cache;
    }

    public function getCallbackCacheService(Container $container): CallbackCache
    {
        return new CallbackCache($container->get(StorageInterface::class), new PatternOptions(['cache_output' => \false]));
    }

    public function getCaptureCacheService(Container $container): CaptureCache
    {
        $publicDir = Paths::captureCacheDir();
        if (!\file_exists($publicDir)) {
            $html = <<<'HTML'
<html><head><title></title></head><body></body></html>';
HTML;

            try {
                File::write($publicDir.'/index.html', $html);
            } catch (\Exception $e) {
            }
            $htaccess = <<<APACHECONFIG
<IfModule mod_autoindex.c>
\tOptions -Indexes
</IfModule>
<IfModule mod_headers.c>
    Header always unset Content-Security-Policy
</IfModule>
APACHECONFIG;

            try {
                File::write($publicDir.'/.htaccess', $htaccess);
            } catch (\Exception $e) {
            }
        }

        return new CaptureCache(new PatternOptions(['public_dir' => $publicDir, 'file_locking' => \true, 'file_permission' => 0644, 'dir_permission' => 0755, 'umask' => \false]));
    }

    /**
     * @return IterableInterface&StorageInterface&TaggableInterface
     */
    public function getTaggableInterfaceService(Container $container)
    {
        $cache = $this->getCacheAdapter($container, $container->get(Registry::class)->get('pro_cache_storage_adapter', 'filesystem'));
        if (!$cache instanceof TaggableInterface || !$cache instanceof IterableInterface) {
            $cache = $this->getCacheAdapter($container, 'filesystem');
        }
        // @var StorageInterface&TaggableInterface&IterableInterface $cache
        $cache->getOptions()->setNamespace('jchoptimizetags')->setTtl(0);

        return $cache;
    }

    public function getPageCacheStorageService(Container $container): StorageInterface
    {
        $cache = $this->getCacheAdapter($container, $container->get(Registry::class)->get('pro_cache_storage_adapter', 'filesystem'));
        $cache->getOptions()->setNamespace(Cache::getCacheNamespace(\true))->setTtl((int) $container->get(Registry::class)->get('page_cache_lifetime', '900'));

        return $cache;
    }

    private function getCacheAdapter(Container $container, string $adapter): StorageInterface
    {
        if ('filesystem' == $adapter) {
            Helper::createCacheFolder();
        }

        try {
            $factory = new StorageCacheAbstractServiceFactory();

            /** @var StorageInterface $cache */
            $cache = $factory($container, $adapter);
            // Let's make sure we can connect
            $cache->addItem(\md5('__ITEM__'), '__ITEM__');

            return $cache;
        } catch (\Throwable $e) {
            $logger = $container->get(LoggerInterface::class);
            $message = 'Error in JCH Optimize retrieving configured storage adapter with message: '.$e->getMessage();
            if ('filesystem' != $adapter) {
                $message .= ': Using the filesystem storage instead';
            }
            $logger->error($message);
            Utility::publishAdminMessages($message, 'error');
            if ('filesystem' != $adapter) {
                return $this->getCacheAdapter($container, 'filesystem');
            }

            throw new Exception\RuntimeException($message);
        }
    }
}
