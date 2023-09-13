<?php

/**
 * Part of the Joomla Framework Renderer Package.
 *
 * @copyright  Copyright (C) 2005 - 2021 Open Source Matters, Inc. All rights reserved.
 * @license    http://www.gnu.org/licenses/lgpl-2.1.txt GNU Lesser General Public License Version 2.1 or Later
 */

namespace _JchOptimizeVendor\Joomla\Renderer;

/**
 * Mustache class for rendering output.
 *
 * @since  2.0.0
 */
class MustacheRenderer extends AbstractRenderer
{
    /**
     * Rendering engine.
     *
     * @var \Mustache_Engine
     *
     * @since  2.0.0
     */
    private $renderer;

    /**
     * Constructor.
     *
     * @param \Mustache_Engine $renderer Rendering engine
     *
     * @since   2.0.0
     */
    public function __construct(\_JchOptimizeVendor\Mustache_Engine $renderer = null)
    {
        $this->renderer = $renderer ?: new \_JchOptimizeVendor\Mustache_Engine();
    }

    /**
     * Get the rendering engine.
     *
     * @return \Mustache_Engine
     *
     * @since   2.0.0
     */
    public function getRenderer()
    {
        return $this->renderer;
    }

    /**
     * Checks if folder, folder alias, template or template path exists.
     *
     * @param string $path Full path or part of a path
     *
     * @return bool True if the path exists
     *
     * @since   2.0.0
     */
    public function pathExists(string $path): bool
    {
        try {
            $this->getRenderer()->getLoader()->load($path);

            return \true;
        } catch (\_JchOptimizeVendor\Mustache_Exception_UnknownTemplateException $e) {
            return \false;
        }
    }

    /**
     * Render and return compiled data.
     *
     * @param string $template The template file name
     * @param array  $data     The data to pass to the template
     *
     * @return string Compiled data
     *
     * @since   2.0.0
     */
    public function render(string $template, array $data = []): string
    {
        $data = \array_merge($this->data, $data);

        return $this->getRenderer()->render($template, $data);
    }
}
