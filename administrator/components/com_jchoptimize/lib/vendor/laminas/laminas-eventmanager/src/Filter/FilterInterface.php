<?php

namespace _JchOptimizeVendor\Laminas\EventManager\Filter;

use _JchOptimizeVendor\Laminas\EventManager\ResponseCollection;

/**
 * Interface for intercepting filter chains.
 */
interface FilterInterface
{
    /**
     * Execute the filter chain.
     *
     * @param object|string $context
     *
     * @return mixed
     */
    public function run($context, array $params = []);

    /**
     * Attach an intercepting filter.
     */
    public function attach(callable $callback);

    /**
     * Detach an intercepting filter.
     *
     * @return bool
     */
    public function detach(callable $filter);

    /**
     * Get all intercepting filters.
     *
     * @return array
     */
    public function getFilters();

    /**
     * Clear all filters.
     */
    public function clearFilters();

    /**
     * Get all filter responses.
     *
     * @return ResponseCollection
     */
    public function getResponses();
}
