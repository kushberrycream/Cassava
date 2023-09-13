<?php

/**
 * Part of the Joomla Framework View Package.
 *
 * @copyright  Copyright (C) 2005 - 2021 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace _JchOptimizeVendor\Joomla\View;

/**
 * Joomla Framework JSON View Class.
 *
 * @since  2.0.0
 */
class JsonView extends AbstractView
{
    /**
     * Method to render the view.
     *
     * @return string the rendered view
     *
     * @since   2.0.0
     */
    public function render()
    {
        return \json_encode($this->getData());
    }
}
