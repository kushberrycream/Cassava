<?php

/**
 * Part of the Joomla Framework DI Package.
 *
 * @copyright  Copyright (C) 2013 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace _JchOptimizeVendor\Joomla\DI;

/**
 * Defines the interface for a Service Provider.
 *
 * @since  1.0
 */
interface ServiceProviderInterface
{
    /**
     * Registers the service provider with a DI container.
     *
     * @param Container $container the DI container
     *
     * @since   1.0
     */
    public function register(Container $container);
}
