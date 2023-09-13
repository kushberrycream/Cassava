<?php

/**
 * Part of the Joomla Framework Renderer Package.
 *
 * @copyright  Copyright (C) 2005 - 2021 Open Source Matters, Inc. All rights reserved.
 * @license    http://www.gnu.org/licenses/lgpl-2.1.txt GNU Lesser General Public License Version 2.1 or Later
 */

namespace _JchOptimizeVendor\Joomla\Renderer;

/**
 * Interface defining a renderer with a configurable file extension.
 *
 * @since  2.0.0
 */
interface ConfigurableFileExtensionInterface
{
    /**
     * Sets file extension for template loader.
     *
     * @param string $extension Template files extension
     *
     * @return $this
     *
     * @since   2.0.0
     */
    public function setFileExtension(string $extension);
}
