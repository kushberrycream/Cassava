<?php

/**
 * Part of the Joomla Framework Model Package.
 *
 * @copyright  Copyright (C) 2005 - 2021 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace _JchOptimizeVendor\Joomla\Model;

use Joomla\Registry\Registry;

/**
 * Joomla Framework Stateful Model Interface.
 *
 * @since  1.3.0
 */
interface StatefulModelInterface
{
    /**
     * Get the model state.
     *
     * @return Registry the state object
     *
     * @since   1.3.0
     */
    public function getState();
}
