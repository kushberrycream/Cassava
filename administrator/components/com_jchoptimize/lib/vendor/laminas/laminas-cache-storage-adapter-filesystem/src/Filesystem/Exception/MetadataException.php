<?php

declare(strict_types=1);

namespace _JchOptimizeVendor\Laminas\Cache\Storage\Adapter\Filesystem\Exception;

use _JchOptimizeVendor\Laminas\Cache\Exception\RuntimeException;
use _JchOptimizeVendor\Laminas\Cache\Storage\Adapter\Filesystem;

final class MetadataException extends RuntimeException
{
    public const METADATA_ATIME = Filesystem::METADATA_ATIME;
    public const METADATA_CTIME = Filesystem::METADATA_CTIME;
    public const METADATA_MTIME = Filesystem::METADATA_MTIME;
    public const METADATA_FILESIZE = Filesystem::METADATA_FILESIZE;

    /** @var \ErrorException */
    private $error;

    /**
     * @psalm-param MetadataException::METADATA_* $metadata
     */
    public function __construct(string $metadata, \ErrorException $error)
    {
        parent::__construct(\sprintf('Could not detected metadata "%s"', $metadata), 0, $error);
        $this->error = $error;
    }

    public function getErrorSeverity(): int
    {
        return $this->error->getSeverity();
    }

    public function getErrorMessage(): string
    {
        return $this->error->getMessage();
    }

    public function getErrorFile(): string
    {
        return $this->error->getFile();
    }

    public function getErrorLine(): int
    {
        return $this->error->getLine();
    }
}
