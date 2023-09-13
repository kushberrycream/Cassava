<?php

declare(strict_types=1);

namespace _JchOptimizeVendor\Laminas\ServiceManager\Factory;

use _JchOptimizeVendor\Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use _JchOptimizeVendor\Laminas\ServiceManager\Exception\ServiceNotFoundException;
use _JchOptimizeVendor\Psr\Container\ContainerExceptionInterface;
use _JchOptimizeVendor\Psr\Container\ContainerInterface;

/**
 * Delegator factory interface.
 *
 * Defines the capabilities required by a delegator factory. Delegator
 * factories are used to either decorate a service instance, or to allow
 * decorating the instantiation of a service instance (for instance, to
 * provide optional dependencies via setters, etc.).
 */
interface DelegatorFactoryInterface
{
    /**
     * A factory that creates delegates of a given service.
     *
     * @param string $name
     *
     * @psalm-param callable():mixed $callback
     *
     * @return object
     *
     * @throws ServiceNotFoundException    if unable to resolve the service
     * @throws ServiceNotCreatedException  if an exception is raised when creating a service
     * @throws ContainerExceptionInterface if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $name, callable $callback, ?array $options = null);
}
