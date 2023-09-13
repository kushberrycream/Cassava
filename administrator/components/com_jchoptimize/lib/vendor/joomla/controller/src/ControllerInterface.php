<?php

/**
 * Part of the Joomla Framework Controller Package.
 *
 * @copyright  Copyright (C) 2005 - 2021 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace _JchOptimizeVendor\Joomla\Controller;

/**
 * Joomla Framework Controller Interface.
 *
 * @since  1.0
 */
interface ControllerInterface
{
    /**
     * Execute the controller.
     *
     * @return bool True if controller finished execution, false if the controller did not
     *              finish execution. A controller might return false if some precondition for
     *              the controller to run has not been satisfied.
     *
     * @since   1.0
     *
     * @throws \LogicException
     * @throws \RuntimeException
     */
    public function execute();
}
