<?php

/**
 * Part of the Joomla Framework DI Package.
 *
 * @copyright  Copyright (C) 2013 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace _JchOptimizeVendor\Joomla\DI;

use _JchOptimizeVendor\Joomla\DI\Exception\ContainerNotFoundException;

/**
 * Defines the trait for a Container Aware Class.
 *
 * @since  1.2
 */
trait ContainerAwareTrait
{
    /**
     * DI Container.
     *
     * @var Container
     *
     * @since  1.2
     */
    private $container;

    /**
     * Set the DI container.
     *
     * @param Container $container the DI container
     *
     * @return $this
     *
     * @since   1.2
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;

        return $this;
    }

    /**
     * Get the DI container.
     *
     * @return Container
     *
     * @since   1.2
     *
     * @throws ContainerNotFoundException may be thrown if the container has not been set
     */
    protected function getContainer()
    {
        if ($this->container) {
            return $this->container;
        }

        throw new ContainerNotFoundException('Container not set in '.\get_class($this));
    }
}
