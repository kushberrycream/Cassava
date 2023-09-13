<?php

declare(strict_types=1);

namespace _JchOptimizeVendor\Laminas\Cache\Storage\Adapter\Filesystem\Exception;

use _JchOptimizeVendor\Laminas\Cache\Exception\RuntimeException;

final class UnlinkException extends RuntimeException
{
    /** @var \ErrorException */
    private $error;

    public function __construct(string $path, \ErrorException $error)
    {
        parent::__construct(\sprintf('Error unlinking file \'%s\'; file still exists', $path), 0, $error);
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
