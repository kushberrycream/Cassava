<?php

namespace _JchOptimizeVendor\Illuminate\View;

interface ViewFinderInterface
{
    /**
     * Hint path delimiter value.
     *
     * @var string
     */
    public const HINT_PATH_DELIMITER = '::';

    /**
     * Get the fully qualified location of the view.
     *
     * @param string $view
     *
     * @return string
     */
    public function find($view);

    /**
     * Add a location to the finder.
     *
     * @param string $location
     */
    public function addLocation($location);

    /**
     * Add a namespace hint to the finder.
     *
     * @param string       $namespace
     * @param array|string $hints
     */
    public function addNamespace($namespace, $hints);

    /**
     * Prepend a namespace hint to the finder.
     *
     * @param string       $namespace
     * @param array|string $hints
     */
    public function prependNamespace($namespace, $hints);

    /**
     * Replace the namespace hints for the given namespace.
     *
     * @param string       $namespace
     * @param array|string $hints
     */
    public function replaceNamespace($namespace, $hints);

    /**
     * Add a valid view extension to the finder.
     *
     * @param string $extension
     */
    public function addExtension($extension);

    /**
     * Flush the cache of located views.
     */
    public function flush();
}
