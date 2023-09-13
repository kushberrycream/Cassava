<?php

/**
 * Part of the Joomla Framework View Package.
 *
 * @copyright  Copyright (C) 2005 - 2021 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace _JchOptimizeVendor\Joomla\View;

/**
 * Joomla Framework View Interface.
 *
 * @since  1.0
 */
interface ViewInterface
{
    /**
     * Method to render the view.
     *
     * @return string the rendered view
     *
     * @since   1.0
     *
     * @throws \RuntimeException
     */
    public function render();
}
