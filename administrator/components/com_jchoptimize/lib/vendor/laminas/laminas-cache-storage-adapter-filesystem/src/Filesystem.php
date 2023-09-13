<?php

declare(strict_types=1);

namespace _JchOptimizeVendor\Laminas\Cache\Storage\Adapter;

use _JchOptimizeVendor\Laminas\Cache\Exception;
use _JchOptimizeVendor\Laminas\Cache\Storage\Adapter\Filesystem\Exception\MetadataException;
use _JchOptimizeVendor\Laminas\Cache\Storage\Adapter\Filesystem\Exception\UnlinkException;
use _JchOptimizeVendor\Laminas\Cache\Storage\Adapter\Filesystem\FilesystemInteractionInterface;
use _JchOptimizeVendor\Laminas\Cache\Storage\Adapter\Filesystem\LocalFilesystemInteraction;
use _JchOptimizeVendor\Laminas\Cache\Storage\AvailableSpaceCapableInterface;
use _JchOptimizeVendor\Laminas\Cache\Storage\Capabilities;
use _JchOptimizeVendor\Laminas\Cache\Storage\ClearByNamespaceInterface;
use _JchOptimizeVendor\Laminas\Cache\Storage\ClearByPrefixInterface;
use _JchOptimizeVendor\Laminas\Cache\Storage\ClearExpiredInterface;
use _JchOptimizeVendor\Laminas\Cache\Storage\FlushableInterface;
use _JchOptimizeVendor\Laminas\Cache\Storage\IterableInterface;
use _JchOptimizeVendor\Laminas\Cache\Storage\OptimizableInterface;
use _JchOptimizeVendor\Laminas\Cache\Storage\TaggableInterface;
use _JchOptimizeVendor\Laminas\Cache\Storage\TotalSpaceCapableInterface;
use _JchOptimizeVendor\Laminas\Stdlib\ErrorHandler;
use Exception as BaseException;

use function glob;
use function max;
use function strlen;
use function time;

final class Filesystem extends AbstractAdapter implements AvailableSpaceCapableInterface, ClearByNamespaceInterface, ClearByPrefixInterface, ClearExpiredInterface, FlushableInterface, IterableInterface, OptimizableInterface, TaggableInterface, TotalSpaceCapableInterface
{
    public const METADATA_ATIME = 'atime';
    public const METADATA_CTIME = 'ctime';
    public const METADATA_MTIME = 'mtime';
    public const METADATA_FILESIZE = 'filesize';
    public const METADATA_FILESPEC = 'filespec';

    /**
     * Buffered total space in bytes.
     *
     * @var null|float|int
     */
    private $totalSpace;

    /**
     * An identity for the last filespec
     * (cache directory + namespace prefix + key + directory level).
     *
     * @var string
     */
    private $lastFileSpecId = '';

    /**
     * The last used filespec.
     *
     * @var string
     */
    private $lastFileSpec = '';

    /** @var FilesystemInteractionInterface */
    private $filesystem;

    /**
     * @param null|AdapterOptions|array|\Traversable $options
     *
     * @throws Exception\ExceptionInterface
     */
    public function __construct($options = null, ?FilesystemInteractionInterface $filesystem = null)
    {
        parent::__construct($options);
        $this->filesystem = $filesystem ?? new LocalFilesystemInteraction();
        // clean total space buffer on change cache_dir
        $events = $this->getEventManager();
        $handle = function (): void {
        };
        $totalSpace = &$this->totalSpace;
        $callback = function ($event) use (&$events, &$handle, &$totalSpace) {
            $params = $event->getParams();
            if (isset($params['cache_dir'])) {
                $totalSpace = null;
                $events->detach($handle);
            }
        };
        $events->attach('option', $callback);
    }

    /**
     * Set options.
     *
     * @see    Filesystem::getOptions()
     *
     * @param array|FilesystemOptions|\Traversable $options
     *
     * @return Filesystem
     */
    public function setOptions($options)
    {
        if (!$options instanceof FilesystemOptions) {
            $options = new FilesystemOptions($options);
        }

        return parent::setOptions($options);
    }

    /**
     * Get options.
     *
     * @see Filesystem::setOptions()
     *
     * @return FilesystemOptions
     */
    public function getOptions()
    {
        if (!$this->options) {
            $this->setOptions(new FilesystemOptions());
        }

        return $this->options;
    }

    // FlushableInterface
    /**
     * Flush the whole storage.
     *
     * @return bool
     *
     * @throws Exception\RuntimeException
     */
    public function flush()
    {
        $flags = \GlobIterator::SKIP_DOTS | \GlobIterator::CURRENT_AS_PATHNAME;
        $dir = $this->getOptions()->getCacheDir();
        $clearFolder = null;
        $clearFolder = function ($dir) use (&$clearFolder, $flags): void {
            $it = new \GlobIterator($dir.\DIRECTORY_SEPARATOR.'*', $flags);
            foreach ($it as $pathname) {
                if ($it->isDir()) {
                    $clearFolder($pathname);
                    \rmdir($pathname);
                } else {
                    // remove the file by ignoring errors if the file doesn't exist afterwards
                    // to fix a possible race condition if another process removed the file already.
                    try {
                        $this->filesystem->delete($pathname);
                    } catch (UnlinkException $exception) {
                        if ($this->filesystem->exists($pathname)) {
                            ErrorHandler::addError($exception->getErrorSeverity(), $exception->getErrorMessage(), $exception->getErrorFile(), $exception->getErrorLine());
                        }
                    }
                }
            }
        };
        ErrorHandler::start();
        $clearFolder($dir);
        $error = ErrorHandler::stop();
        if ($error) {
            throw new Exception\RuntimeException("Flushing directory '{$dir}' failed", 0, $error);
        }

        return \true;
    }

    // ClearExpiredInterface
    /**
     * Remove expired items.
     *
     * @return bool
     *
     * @triggers clearExpired.exception(ExceptionEvent)
     */
    public function clearExpired()
    {
        $options = $this->getOptions();
        $namespace = $options->getNamespace();
        $prefix = '' === $namespace ? '' : $namespace.$options->getNamespaceSeparator();
        $flags = \GlobIterator::SKIP_DOTS | \GlobIterator::CURRENT_AS_PATHNAME;
        $path = $options->getCacheDir().\str_repeat(\DIRECTORY_SEPARATOR.$prefix.'*', $options->getDirLevel()).\DIRECTORY_SEPARATOR.$prefix.'*.'.$this->escapeSuffixForGlob($this->getOptions()->getSuffix());
        $glob = new \GlobIterator($path, $flags);
        $time = \time();
        $ttl = $options->getTtl();
        ErrorHandler::start();
        foreach ($glob as $pathname) {
            // get last modification time of the file but ignore if the file is missing
            // to fix a possible race condition if another process removed the file already.
            try {
                $mtime = $this->filesystem->lastModifiedTime($pathname);
            } catch (MetadataException $exception) {
                if ($this->filesystem->exists($pathname)) {
                    ErrorHandler::addError($exception->getErrorSeverity(), $exception->getErrorMessage(), $exception->getErrorFile(), $exception->getErrorLine());
                }

                continue;
            }
            if ($time >= $mtime + $ttl) {
                // remove the file by ignoring errors if the file doesn't exist afterwards
                // to fix a possible race condition if another process removed the file already.
                try {
                    $this->filesystem->delete($pathname);
                } catch (UnlinkException $exception) {
                    if ($this->filesystem->exists($pathname)) {
                        ErrorHandler::addError($exception->getErrorSeverity(), $exception->getErrorMessage(), $exception->getErrorFile(), $exception->getErrorLine());
                    } else {
                        $tagPathname = $this->formatTagFilename(\substr($pathname, 0, -4));

                        try {
                            $this->filesystem->delete($tagPathname);
                        } catch (UnlinkException $exception) {
                            ErrorHandler::addError($exception->getErrorSeverity(), $exception->getErrorMessage(), $exception->getErrorFile(), $exception->getErrorLine());
                        }
                    }
                }
            }
        }
        $error = ErrorHandler::stop();
        if ($error) {
            $result = \false;

            return $this->triggerException(__FUNCTION__, new \ArrayObject(), $result, new Exception\RuntimeException('Failed to clear expired items', 0, $error));
        }

        return \true;
    }

    // ClearByNamespaceInterface
    /**
     * Remove items by given namespace.
     *
     * @param string $namespace
     *
     * @return bool
     *
     * @throws Exception\RuntimeException
     */
    public function clearByNamespace($namespace)
    {
        $namespace = (string) $namespace;
        if ('' === $namespace) {
            throw new Exception\InvalidArgumentException('No namespace given');
        }
        $options = $this->getOptions();
        $prefix = $namespace.$options->getNamespaceSeparator();
        $flags = \GlobIterator::SKIP_DOTS | \GlobIterator::CURRENT_AS_PATHNAME;
        $path = $options->getCacheDir().\str_repeat(\DIRECTORY_SEPARATOR.$prefix.'*', $options->getDirLevel()).\DIRECTORY_SEPARATOR.$prefix.'*.*';
        $glob = new \GlobIterator($path, $flags);
        ErrorHandler::start();
        foreach ($glob as $pathname) {
            // remove the file by ignoring errors if the file doesn't exist afterwards
            // to fix a possible race condition if another process removed the file already.
            try {
                $this->filesystem->delete($pathname);
            } catch (UnlinkException $exception) {
                if ($this->filesystem->exists($pathname)) {
                    ErrorHandler::addError($exception->getErrorSeverity(), $exception->getErrorMessage(), $exception->getErrorFile(), $exception->getErrorLine());
                }
            }
        }
        $err = ErrorHandler::stop();
        if ($err) {
            $result = \false;

            return $this->triggerException(__FUNCTION__, new \ArrayObject(), $result, new Exception\RuntimeException("Failed to clear items of namespace '{$namespace}'", 0, $err));
        }

        return \true;
    }

    // ClearByPrefixInterface
    /**
     * Remove items matching given prefix.
     *
     * @param string $prefix
     *
     * @return bool
     *
     * @throws Exception\RuntimeException
     */
    public function clearByPrefix($prefix)
    {
        $prefix = (string) $prefix;
        if ('' === $prefix) {
            throw new Exception\InvalidArgumentException('No prefix given');
        }
        $options = $this->getOptions();
        $namespace = $options->getNamespace();
        $nsPrefix = '' === $namespace ? '' : $namespace.$options->getNamespaceSeparator();
        $flags = \GlobIterator::SKIP_DOTS | \GlobIterator::CURRENT_AS_PATHNAME;
        $path = $options->getCacheDir().\str_repeat(\DIRECTORY_SEPARATOR.$nsPrefix.'*', $options->getDirLevel()).\DIRECTORY_SEPARATOR.$nsPrefix.$prefix.'*.*';
        $glob = new \GlobIterator($path, $flags);
        ErrorHandler::start();
        foreach ($glob as $pathname) {
            \assert(\is_string($pathname));
            // remove the file by ignoring errors if the file doesn't exist afterwards
            // to fix a possible race condition if another process removed the file already.
            try {
                $this->filesystem->delete($pathname);
            } catch (UnlinkException $exception) {
                if ($this->filesystem->exists($pathname)) {
                    ErrorHandler::addError($exception->getErrorSeverity(), $exception->getErrorMessage(), $exception->getErrorFile(), $exception->getErrorLine());
                }
            }
        }
        $err = ErrorHandler::stop();
        if ($err) {
            $result = \false;

            return $this->triggerException(__FUNCTION__, new \ArrayObject(), $result, new Exception\RuntimeException("Failed to remove files of '{$path}'", 0, $err));
        }

        return \true;
    }

    // TaggableInterface
    /**
     * Set tags to an item by given key.
     * An empty array will remove all tags.
     *
     * @param string   $key
     * @param string[] $tags
     *
     * @return bool
     */
    public function setTags($key, array $tags)
    {
        $this->normalizeKey($key);
        if (!$this->internalHasItem($key)) {
            return \false;
        }
        $filespec = $this->getFileSpec($key);
        if (!$tags) {
            $this->filesystem->delete($this->formatTagFilename($filespec));

            return \true;
        }
        $this->putFileContent($this->formatTagFilename($filespec), \implode("\n", $tags));

        return \true;
    }

    /**
     * Get tags of an item by given key.
     *
     * @param string $key
     *
     * @return false|string[]
     */
    public function getTags($key)
    {
        $this->normalizeKey($key);
        if (!$this->internalHasItem($key)) {
            return \false;
        }
        $filespec = $this->formatTagFilename($this->getFileSpec($key));
        $tags = [];
        if ($this->filesystem->exists($filespec)) {
            $tags = \explode("\n", $this->getFileContent($filespec));
        }

        return $tags;
    }

    /**
     * Remove items matching given tags.
     *
     * If $disjunction only one of the given tags must match
     * else all given tags must match.
     *
     * @param string[] $tags
     * @param bool     $disjunction
     *
     * @return bool
     */
    public function clearByTags(array $tags, $disjunction = \false)
    {
        if (!$tags) {
            return \true;
        }
        $tagCount = \count($tags);
        $options = $this->getOptions();
        $namespace = $options->getNamespace();
        $prefix = '' === $namespace ? '' : $namespace.$options->getNamespaceSeparator();
        $flags = \GlobIterator::SKIP_DOTS | \GlobIterator::CURRENT_AS_PATHNAME;
        $path = $options->getCacheDir().\str_repeat(\DIRECTORY_SEPARATOR.$prefix.'*', $options->getDirLevel()).\DIRECTORY_SEPARATOR.$prefix.'*.'.$this->escapeSuffixForGlob($this->getOptions()->getTagSuffix());
        $glob = new \GlobIterator($path, $flags);
        foreach ($glob as $pathname) {
            \assert(\is_string($pathname));

            try {
                $diff = \array_diff($tags, \explode("\n", $this->getFileContent($pathname)));
            } catch (Exception\RuntimeException $exception) {
                // ignore missing files because of possible raise conditions
                // e.g. another process already deleted that item
                if (!$this->filesystem->exists($pathname)) {
                    continue;
                }

                throw $exception;
            }
            $rem = \false;
            if ($disjunction && \count($diff) < $tagCount) {
                $rem = \true;
            } elseif (!$disjunction && !$diff) {
                $rem = \true;
            }
            if ($rem) {
                $this->filesystem->delete($pathname);
                $datPathname = $this->formatFilename(\substr($pathname, 0, -4));
                if ($this->filesystem->exists($datPathname)) {
                    $this->filesystem->delete($datPathname);
                }
            }
        }

        return \true;
    }

    // IterableInterface
    /**
     * Get the storage iterator.
     *
     * @return FilesystemIterator
     */
    public function getIterator(): \Traversable
    {
        $options = $this->getOptions();
        $namespace = $options->getNamespace();
        $prefix = '' === $namespace ? '' : $namespace.$options->getNamespaceSeparator();
        $path = $options->getCacheDir().\str_repeat(\DIRECTORY_SEPARATOR.$prefix.'*', $options->getDirLevel()).\DIRECTORY_SEPARATOR.$prefix.'*.'.$this->escapeSuffixForGlob($this->getOptions()->getSuffix());

        return new FilesystemIterator($this, $path, $prefix);
    }

    // OptimizableInterface
    /**
     * Optimize the storage.
     *
     * @return bool
     *
     * @throws Exception\RuntimeException
     */
    public function optimize()
    {
        $options = $this->getOptions();
        if ($options->getDirLevel()) {
            $namespace = $options->getNamespace();
            $prefix = '' === $namespace ? '' : $namespace.$options->getNamespaceSeparator();
            // removes only empty directories
            $this->clearAndDeleteDirectory($options->getCacheDir(), $prefix);
        }

        return \true;
    }

    // TotalSpaceCapableInterface
    /**
     * Get total space in bytes.
     *
     * @return float|int
     *
     * @throws Exception\RuntimeException
     */
    public function getTotalSpace()
    {
        if (null === $this->totalSpace) {
            $path = $this->getOptions()->getCacheDir();
            $this->totalSpace = (float) $this->filesystem->totalBytes($path);
        }

        return $this->totalSpace;
    }

    // AvailableSpaceCapableInterface
    /**
     * Get available space in bytes.
     *
     * @return float
     *
     * @throws Exception\RuntimeException
     */
    public function getAvailableSpace()
    {
        $path = $this->getOptions()->getCacheDir();

        return (float) $this->filesystem->availableBytes($path);
    }

    // reading
    /**
     * Get an item.
     *
     * @param string $key
     * @param bool   $success
     * @param mixed  $casToken
     *
     * @return mixed Data on success, null on failure
     *
     * @throws Exception\ExceptionInterface
     *
     * @triggers getItem.pre(PreEvent)
     * @triggers getItem.post(PostEvent)
     * @triggers getItem.exception(ExceptionEvent)
     */
    public function getItem($key, &$success = null, &$casToken = null)
    {
        $options = $this->getOptions();
        if ($options->getReadable() && $options->getClearStatCache()) {
            $this->filesystem->clearStatCache();
        }
        $argn = \func_num_args();
        if ($argn > 2) {
            return parent::getItem($key, $success, $casToken);
        }
        if ($argn > 1) {
            return parent::getItem($key, $success);
        }

        return parent::getItem($key);
    }

    /**
     * Get multiple items.
     *
     * @return array Associative array of keys and values
     *
     * @throws Exception\ExceptionInterface
     *
     * @triggers getItems.pre(PreEvent)
     * @triggers getItems.post(PostEvent)
     * @triggers getItems.exception(ExceptionEvent)
     */
    public function getItems(array $keys)
    {
        $options = $this->getOptions();
        if ($options->getReadable() && $options->getClearStatCache()) {
            $this->filesystem->clearStatCache();
        }

        return parent::getItems($keys);
    }

    /**
     * Test if an item exists.
     *
     * @param string $key
     *
     * @return bool
     *
     * @throws Exception\ExceptionInterface
     *
     * @triggers hasItem.pre(PreEvent)
     * @triggers hasItem.post(PostEvent)
     * @triggers hasItem.exception(ExceptionEvent)
     */
    public function hasItem($key)
    {
        $options = $this->getOptions();
        if ($options->getReadable() && $options->getClearStatCache()) {
            $this->filesystem->clearStatCache();
        }

        return parent::hasItem($key);
    }

    /**
     * Test multiple items.
     *
     * @return array Array of found keys
     *
     * @throws Exception\ExceptionInterface
     *
     * @triggers hasItems.pre(PreEvent)
     * @triggers hasItems.post(PostEvent)
     * @triggers hasItems.exception(ExceptionEvent)
     */
    public function hasItems(array $keys)
    {
        $options = $this->getOptions();
        if ($options->getReadable() && $options->getClearStatCache()) {
            $this->filesystem->clearStatCache();
        }

        return parent::hasItems($keys);
    }

    /**
     * Get metadata.
     *
     * @param string $key
     *
     * @return array|bool Metadata on success, false on failure
     */
    public function getMetadata($key)
    {
        $options = $this->getOptions();
        if ($options->getReadable() && $options->getClearStatCache()) {
            $this->filesystem->clearStatCache();
        }

        return parent::getMetadata($key);
    }

    /**
     * Get metadatas.
     *
     * @return array Associative array of keys and metadata
     */
    public function getMetadatas(array $keys, array $options = [])
    {
        $options = $this->getOptions();
        if ($options->getReadable() && $options->getClearStatCache()) {
            $this->filesystem->clearStatCache();
        }

        return parent::getMetadatas($keys);
    }

    // writing
    /**
     * Store an item.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return bool
     *
     * @throws Exception\ExceptionInterface
     *
     * @triggers setItem.pre(PreEvent)
     * @triggers setItem.post(PostEvent)
     * @triggers setItem.exception(ExceptionEvent)
     */
    public function setItem($key, $value)
    {
        $options = $this->getOptions();
        if ($options->getWritable() && $options->getClearStatCache()) {
            $this->filesystem->clearStatCache();
        }

        return parent::setItem($key, $value);
    }

    /**
     * Store multiple items.
     *
     * @return array Array of not stored keys
     *
     * @throws Exception\ExceptionInterface
     *
     * @triggers setItems.pre(PreEvent)
     * @triggers setItems.post(PostEvent)
     * @triggers setItems.exception(ExceptionEvent)
     */
    public function setItems(array $keyValuePairs)
    {
        $options = $this->getOptions();
        if ($options->getWritable() && $options->getClearStatCache()) {
            $this->filesystem->clearStatCache();
        }

        return parent::setItems($keyValuePairs);
    }

    /**
     * Add an item.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return bool
     *
     * @throws Exception\ExceptionInterface
     *
     * @triggers addItem.pre(PreEvent)
     * @triggers addItem.post(PostEvent)
     * @triggers addItem.exception(ExceptionEvent)
     */
    public function addItem($key, $value)
    {
        $options = $this->getOptions();
        if ($options->getWritable() && $options->getClearStatCache()) {
            $this->filesystem->clearStatCache();
        }

        return parent::addItem($key, $value);
    }

    /**
     * Add multiple items.
     *
     * @return bool
     *
     * @throws Exception\ExceptionInterface
     *
     * @triggers addItems.pre(PreEvent)
     * @triggers addItems.post(PostEvent)
     * @triggers addItems.exception(ExceptionEvent)
     */
    public function addItems(array $keyValuePairs)
    {
        $options = $this->getOptions();
        if ($options->getWritable() && $options->getClearStatCache()) {
            $this->filesystem->clearStatCache();
        }

        return parent::addItems($keyValuePairs);
    }

    /**
     * Replace an existing item.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return bool
     *
     * @throws Exception\ExceptionInterface
     *
     * @triggers replaceItem.pre(PreEvent)
     * @triggers replaceItem.post(PostEvent)
     * @triggers replaceItem.exception(ExceptionEvent)
     */
    public function replaceItem($key, $value)
    {
        $options = $this->getOptions();
        if ($options->getWritable() && $options->getClearStatCache()) {
            $this->filesystem->clearStatCache();
        }

        return parent::replaceItem($key, $value);
    }

    /**
     * Replace multiple existing items.
     *
     * @return bool
     *
     * @throws Exception\ExceptionInterface
     *
     * @triggers replaceItems.pre(PreEvent)
     * @triggers replaceItems.post(PostEvent)
     * @triggers replaceItems.exception(ExceptionEvent)
     */
    public function replaceItems(array $keyValuePairs)
    {
        $options = $this->getOptions();
        if ($options->getWritable() && $options->getClearStatCache()) {
            $this->filesystem->clearStatCache();
        }

        return parent::replaceItems($keyValuePairs);
    }

    /**
     * Set an item only if token matches.
     *
     * It uses the token received from getItem() to check if the item has
     * changed before overwriting it.
     *
     * @see    Filesystem::getItem()
     * @see    Filesystem::setItem()
     *
     * @param mixed  $token
     * @param string $key
     * @param mixed  $value
     *
     * @return bool
     *
     * @throws Exception\ExceptionInterface
     */
    public function checkAndSetItem($token, $key, $value)
    {
        $options = $this->getOptions();
        if ($options->getWritable() && $options->getClearStatCache()) {
            $this->filesystem->clearStatCache();
        }

        return parent::checkAndSetItem($token, $key, $value);
    }

    /**
     * Reset lifetime of an item.
     *
     * @param string $key
     *
     * @return bool
     *
     * @throws Exception\ExceptionInterface
     *
     * @triggers touchItem.pre(PreEvent)
     * @triggers touchItem.post(PostEvent)
     * @triggers touchItem.exception(ExceptionEvent)
     */
    public function touchItem($key)
    {
        $options = $this->getOptions();
        if ($options->getWritable() && $options->getClearStatCache()) {
            $this->filesystem->clearStatCache();
        }

        return parent::touchItem($key);
    }

    /**
     * Reset lifetime of multiple items.
     *
     * @return array Array of not updated keys
     *
     * @throws Exception\ExceptionInterface
     *
     * @triggers touchItems.pre(PreEvent)
     * @triggers touchItems.post(PostEvent)
     * @triggers touchItems.exception(ExceptionEvent)
     */
    public function touchItems(array $keys)
    {
        $options = $this->getOptions();
        if ($options->getWritable() && $options->getClearStatCache()) {
            $this->filesystem->clearStatCache();
        }

        return parent::touchItems($keys);
    }

    /**
     * Remove an item.
     *
     * @param string $key
     *
     * @return bool
     *
     * @throws Exception\ExceptionInterface
     *
     * @triggers removeItem.pre(PreEvent)
     * @triggers removeItem.post(PostEvent)
     * @triggers removeItem.exception(ExceptionEvent)
     */
    public function removeItem($key)
    {
        $options = $this->getOptions();
        if ($options->getWritable() && $options->getClearStatCache()) {
            $this->filesystem->clearStatCache();
        }

        return parent::removeItem($key);
    }

    /**
     * Remove multiple items.
     *
     * @return array Array of not removed keys
     *
     * @throws Exception\ExceptionInterface
     *
     * @triggers removeItems.pre(PreEvent)
     * @triggers removeItems.post(PostEvent)
     * @triggers removeItems.exception(ExceptionEvent)
     */
    public function removeItems(array $keys)
    {
        $options = $this->getOptions();
        if ($options->getWritable() && $options->getClearStatCache()) {
            $this->filesystem->clearStatCache();
        }

        return parent::removeItems($keys);
    }

    /**
     * Internal method to get an item.
     *
     * @param string $normalizedKey
     * @param bool   $success
     * @param mixed  $casToken
     *
     * @return null|mixed Data on success, null on failure
     *
     * @throws Exception\ExceptionInterface
     * @throws BaseException
     */
    protected function internalGetItem(&$normalizedKey, &$success = null, &$casToken = null)
    {
        if (!$this->internalHasItem($normalizedKey)) {
            $success = \false;

            return;
        }

        try {
            $filespec = $this->formatFilename($this->getFileSpec($normalizedKey));
            $data = $this->getFileContent($filespec);
            // use filemtime + filesize as CAS token
            if (\func_num_args() > 2) {
                try {
                    $casToken = $this->filesystem->lastModifiedTime($filespec).$this->filesystem->filesize($filespec);
                } catch (MetadataException $exception) {
                    $casToken = '';
                }
            }
            $success = \true;

            return $data;
        } catch (BaseException $e) {
            $success = \false;

            throw $e;
        }
    }

    /**
     * Internal method to get multiple items.
     *
     * @return array Associative array of keys and values
     *
     * @throws Exception\ExceptionInterface
     */
    protected function internalGetItems(array &$normalizedKeys)
    {
        $keys = $normalizedKeys;
        // Don't change argument passed by reference
        $result = [];
        while ($keys) {
            // LOCK_NB if more than one items have to read
            $nonBlocking = \count($keys) > 1;
            $wouldblock = null;
            // read items
            foreach ($keys as $i => $key) {
                if (!$this->internalHasItem($key)) {
                    unset($keys[$i]);

                    continue;
                }
                $filespec = $this->formatFilename($this->getFileSpec($key));
                $data = $this->getFileContent($filespec, $nonBlocking, $wouldblock);
                if ($nonBlocking && $wouldblock) {
                    continue;
                }
                unset($keys[$i]);

                $result[$key] = $data;
            }
            // TODO: Don't check ttl after first iteration
            // $options['ttl'] = 0;
        }

        return $result;
    }

    /**
     * Internal method to test if an item exists.
     *
     * @param string $normalizedKey
     *
     * @return bool
     *
     * @throws Exception\ExceptionInterface
     */
    protected function internalHasItem(&$normalizedKey)
    {
        $file = $this->formatFilename($this->getFileSpec($normalizedKey));
        if (!$this->filesystem->exists($file)) {
            return \false;
        }
        $ttl = $this->getOptions()->getTtl();
        if ($ttl) {
            $mtime = $this->filesystem->lastModifiedTime($file);
            if (\time() >= $mtime + $ttl) {
                return \false;
            }
        }

        return \true;
    }

    /**
     * Get info by key.
     *
     * @param string $normalizedKey
     *
     * @return array|bool Metadata on success, false on failure
     */
    protected function internalGetMetadata(&$normalizedKey)
    {
        if (!$this->internalHasItem($normalizedKey)) {
            return \false;
        }
        $options = $this->getOptions();
        $filespec = $this->getFileSpec($normalizedKey);
        $file = $this->formatFilename($filespec);

        try {
            $mtime = $this->filesystem->lastModifiedTime($file);
        } catch (Exception\RuntimeException $exception) {
            $mtime = \false;
        }
        $metadata = [self::METADATA_FILESPEC => $filespec, self::METADATA_MTIME => $mtime];
        if (!$options->getNoCtime()) {
            try {
                $ctime = $this->filesystem->createdTime($file);
            } catch (Exception\RuntimeException $exception) {
                $ctime = \false;
            }
            $metadata[self::METADATA_CTIME] = $ctime;
        }
        if (!$options->getNoAtime()) {
            try {
                $atime = $this->filesystem->lastAccessedTime($file);
            } catch (Exception\RuntimeException $exception) {
                $atime = \false;
            }
            $metadata[self::METADATA_ATIME] = $atime;
        }

        return $metadata;
    }

    /**
     * Internal method to store an item.
     *
     * @param string $normalizedKey
     * @param mixed  $value
     *
     * @return bool
     *
     * @throws Exception\ExceptionInterface
     */
    protected function internalSetItem(&$normalizedKey, &$value)
    {
        $filespec = $this->getFileSpec($normalizedKey);
        $file = $this->formatFilename($filespec);
        $this->prepareDirectoryStructure($filespec);
        // write data in non-blocking mode
        $this->putFileContent($file, (string) $value, \true, $wouldblock);
        // delete related tag file (if present)
        $this->filesystem->delete($this->formatTagFilename($filespec));
        // Retry writing data in blocking mode if it was blocked before
        if ($wouldblock) {
            $this->putFileContent($file, (string) $value);
        }

        return \true;
    }

    /**
     * Internal method to store multiple items.
     *
     * @return array Array of not stored keys
     *
     * @throws Exception\ExceptionInterface
     */
    protected function internalSetItems(array &$normalizedKeyValuePairs)
    {
        // create an associated array of files and contents to write
        $contents = [];
        foreach ($normalizedKeyValuePairs as $key => &$value) {
            $filespec = $this->getFileSpec((string) $key);
            $this->prepareDirectoryStructure($filespec);
            // *.dat file
            $contents[$this->formatFilename($filespec)] = &$value;
            // *.tag file
            $this->filesystem->delete($this->formatTagFilename($filespec));
        }
        // write to disk
        while ($contents) {
            $nonBlocking = \count($contents) > 1;
            foreach ($contents as $file => &$content) {
                $wouldblock = null;
                $this->putFileContent($file, (string) $content, $nonBlocking, $wouldblock);
                if (!$nonBlocking || !$wouldblock) {
                    unset($contents[$file]);
                }
            }
        }
        // return OK
        return [];
    }

    /**
     * Internal method to set an item only if token matches.
     *
     * @see    Filesystem::getItem()
     * @see    Filesystem::setItem()
     *
     * @param mixed  $token
     * @param string $normalizedKey
     * @param mixed  $value
     *
     * @return bool
     *
     * @throws Exception\ExceptionInterface
     */
    protected function internalCheckAndSetItem(&$token, &$normalizedKey, &$value)
    {
        if (!$this->internalHasItem($normalizedKey)) {
            return \false;
        }
        // use filemtime + filesize as CAS token
        $file = $this->formatFilename($this->getFileSpec($normalizedKey));

        try {
            $check = $this->filesystem->lastModifiedTime($file).$this->filesystem->filesize($file);
        } catch (MetadataException $exception) {
            $check = '';
        }
        if ($token !== $check) {
            return \false;
        }

        return $this->internalSetItem($normalizedKey, $value);
    }

    /**
     * Internal method to reset lifetime of an item.
     *
     * @param string $normalizedKey
     *
     * @return bool
     *
     * @throws Exception\ExceptionInterface
     */
    protected function internalTouchItem(&$normalizedKey)
    {
        if (!$this->internalHasItem($normalizedKey)) {
            return \false;
        }
        $filespec = $this->getFileSpec($normalizedKey);
        $file = $this->formatFilename($filespec);

        return $this->filesystem->touch($file);
    }

    /**
     * Internal method to remove an item.
     *
     * @param string $normalizedKey
     *
     * @return bool
     *
     * @throws Exception\ExceptionInterface
     */
    protected function internalRemoveItem(&$normalizedKey)
    {
        $filespec = $this->getFileSpec($normalizedKey);
        $file = $this->formatFilename($filespec);
        if (!$this->filesystem->exists($file)) {
            return \false;
        }
        $this->filesystem->delete($file);
        $this->filesystem->delete($this->formatTagFilename($filespec));

        return \true;
    }

    // status
    /**
     * Internal method to get capabilities of this adapter.
     *
     * @return Capabilities
     */
    protected function internalGetCapabilities()
    {
        if (null === $this->capabilities) {
            $marker = new \stdClass();
            $options = $this->getOptions();
            // detect metadata
            $metadata = [self::METADATA_MTIME, self::METADATA_FILESPEC];
            if (!$options->getNoAtime()) {
                $metadata[] = self::METADATA_ATIME;
            }
            if (!$options->getNoCtime()) {
                $metadata[] = self::METADATA_CTIME;
            }
            // Calculate max key length: 255 - strlen(.) - strlen(dat | tag)
            $maxKeyLength = 255 - 1 - \max([\strlen($options->getSuffix()), \strlen($options->getTagSuffix())]);
            $namespace = $options->getNamespace();
            if ('' !== $namespace) {
                $maxKeyLength -= \strlen($namespace) + \strlen($options->getNamespaceSeparator());
            }
            if ($maxKeyLength < 1) {
                throw new Exception\RuntimeException('Invalid maximum key length was calculated. This usually happens if the used namespace is too long.');
            }
            $capabilities = new Capabilities($this, $marker, ['supportedDatatypes' => ['NULL' => 'string', 'boolean' => 'string', 'integer' => 'string', 'double' => 'string', 'string' => \true, 'array' => \false, 'object' => \false, 'resource' => \false], 'supportedMetadata' => $metadata, 'minTtl' => 1, 'maxTtl' => 0, 'staticTtl' => \false, 'ttlPrecision' => 1, 'maxKeyLength' => $maxKeyLength, 'namespaceIsPrefix' => \true, 'namespaceSeparator' => $options->getNamespaceSeparator()]);
            // update capabilities on change options
            $this->getEventManager()->attach('option', function ($event) use ($capabilities, $marker) {
                $params = $event->getParams();
                if (isset($params['namespace_separator'])) {
                    $capabilities->setNamespaceSeparator($marker, $params['namespace_separator']);
                }
                if (isset($params['no_atime']) || isset($params['no_ctime'])) {
                    $metadata = $capabilities->getSupportedMetadata();
                    if (isset($params['no_atime']) && !$params['no_atime']) {
                        $metadata[] = self::METADATA_ATIME;
                    } elseif (isset($params['no_atime']) && ($index = \array_search(self::METADATA_ATIME, $metadata)) !== \false) {
                        unset($metadata[$index]);
                    }
                    if (isset($params['no_ctime']) && !$params['no_ctime']) {
                        $metadata[] = self::METADATA_CTIME;
                    } elseif (isset($params['no_ctime']) && ($index = \array_search(self::METADATA_CTIME, $metadata)) !== \false) {
                        unset($metadata[$index]);
                    }
                    $capabilities->setSupportedMetadata($marker, $metadata);
                }
            });
            $this->capabilityMarker = $marker;
            $this->capabilities = $capabilities;
        }

        return $this->capabilities;
    }

    // internal
    /**
     * Removes directories recursive by namespace.
     */
    private function clearAndDeleteDirectory(string $dir, string $prefix): bool
    {
        $glob = \glob($dir.\DIRECTORY_SEPARATOR.$prefix.'*', \GLOB_ONLYDIR | \GLOB_NOESCAPE | \GLOB_NOSORT);
        if (!$glob) {
            // On some systems glob returns false even on empty result
            return \true;
        }
        $ret = \true;
        foreach ($glob as $subdir) {
            // skip removing current directory if removing of sub-directory failed
            if ($this->clearAndDeleteDirectory($subdir, $prefix)) {
                // ignore not empty directories
                ErrorHandler::start();
                $ret = \rmdir($subdir) && $ret;
                ErrorHandler::stop();
            } else {
                $ret = \false;
            }
        }

        return $ret;
    }

    /**
     * Get file spec of the given key and namespace.
     */
    private function getFileSpec(string $normalizedKey): string
    {
        $options = $this->getOptions();
        $namespace = $options->getNamespace();
        $prefix = '' === $namespace ? '' : $namespace.$options->getNamespaceSeparator();
        $path = $options->getCacheDir().\DIRECTORY_SEPARATOR;
        $level = $options->getDirLevel();
        $fileSpecId = $path.$prefix.$normalizedKey.'/'.$level;
        if ($this->lastFileSpecId !== $fileSpecId) {
            if ($level > 0) {
                // create up to 256 directories per directory level
                $hash = \md5($normalizedKey);
                for ($i = 0, $max = $level * 2; $i < $max; $i += 2) {
                    $path .= $prefix.$hash[$i].$hash[$i + 1].\DIRECTORY_SEPARATOR;
                }
            }
            $this->lastFileSpecId = $fileSpecId;
            $this->lastFileSpec = $path.$prefix.$normalizedKey;
        }

        return $this->lastFileSpec;
    }

    /**
     * Read a complete file.
     *
     * @param string $file        File complete path
     * @param bool   $nonBlocking Don't block script if file is locked
     * @param bool   $wouldblock  The optional argument is set to TRUE if the lock would block
     *
     * @throws Exception\RuntimeException
     */
    private function getFileContent(string $file, bool $nonBlocking = \false, ?bool &$wouldblock = null): string
    {
        $options = $this->getOptions();
        $locking = $options->getFileLocking();

        return $this->filesystem->read($file, $locking, $nonBlocking, $wouldblock);
    }

    /**
     * Prepares a directory structure for the given file(spec)
     * using the configured directory level.
     *
     * @throws Exception\RuntimeException
     */
    private function prepareDirectoryStructure(string $file): void
    {
        $options = $this->getOptions();
        $level = $options->getDirLevel();
        // Directory structure is required only if directory level > 0
        if (!$level) {
            return;
        }
        // Directory structure already exists
        $pathname = \dirname($file);
        if ($this->filesystem->exists($pathname)) {
            return;
        }
        $perm = $options->getDirPermission();
        $umask = $options->getUmask();
        if (\false !== $umask && \false !== $perm) {
            $perm &= ~$umask;
        }
        ErrorHandler::start();
        if (\false === $perm || 1 === $level) {
            $this->filesystem->createDirectory($pathname, \false !== $perm ? $perm : 0775, \true, \false !== $umask ? $umask : null);
        } else {
            // built-in mkdir function sets permission together with current umask
            // which doesn't work well on multi threaded webservers
            // -> create directories one by one and set permissions
            // find existing path and missing path parts
            $parts = [];
            $path = $pathname;
            while (!$this->filesystem->exists($path)) {
                \array_unshift($parts, \basename($path));
                $nextPath = \dirname($path);
                if ($nextPath === $path) {
                    break;
                }
                $path = $nextPath;
            }
            // make all missing path parts
            foreach ($parts as $part) {
                $path .= \DIRECTORY_SEPARATOR.$part;
                // create a single directory, set and reset umask immediately
                $this->filesystem->createDirectory($path, $perm, \false, \false !== $umask ? $umask : null);
            }
        }
        ErrorHandler::stop();
    }

    /**
     * Write content to a file.
     *
     * @param bool      $nonBlocking Don't block script if file is locked
     * @param null|bool $wouldblock  The optional argument is set to true if the lock would block
     *
     * @throws Exception\RuntimeException
     */
    private function putFileContent(string $file, string $data, bool $nonBlocking = \false, ?bool &$wouldblock = null): void
    {
        $options = $this->getOptions();
        $umask = $options->getUmask();
        $permissions = $options->getFilePermission();
        $this->filesystem->write($file, $data, \false !== $umask ? $umask : null, \false !== $permissions ? $permissions : null, $options->getFileLocking(), $nonBlocking, $wouldblock);
    }

    /**
     * Formats the filename, appending the suffix option.
     */
    private function formatFilename(string $filename): string
    {
        return \sprintf('%s.%s', $filename, $this->getOptions()->getSuffix());
    }

    /**
     * Formats the filename, appending the tag suffix option.
     */
    private function formatTagFilename(string $filename): string
    {
        return \sprintf('%s.%s', $filename, $this->getOptions()->getTagSuffix());
    }

    /**
     * Escapes a filename suffix to be safe for glob operations.
     *
     * Wraps any of *, ?, or [ characters within [] brackets.
     */
    private function escapeSuffixForGlob(string $suffix): string
    {
        return \preg_replace('#([*?\\[])#', '[$1]', $suffix);
    }
}
