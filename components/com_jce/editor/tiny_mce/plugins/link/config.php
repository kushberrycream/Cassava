<?php

/**
 * @copyright     Copyright (c) 2009-2022 Ryan Demmer. All rights reserved
 * @license       GNU/GPL 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * JCE is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses
 */
class WFLinkPluginConfig
{
    public static function getConfig(&$settings)
    {
        require_once __DIR__ . '/link.php';

        $plugin = new WFLinkPlugin();
        $attributes = $plugin->getDefaults();

        $config = array(
            'attributes' => $plugin->getDefaults()
        );

        // expose globally for use by Autolink and Clipboard
        $settings['default_link_target'] = $plugin->getParam('target', '');
        
        // expose globally for use by Autolink and Clipboard (must be boolean)
        $settings['autolink_email'] = $plugin->getParam('autolink_email', 1, 1, 'boolean');
        $settings['autolink_url'] = $plugin->getParam('autolink_url', 1, 1, 'boolean');

        if ($plugin->getParam('link.quicklink', 1) == 0) {
            $config['quicklink'] = false;
        }

        if ($plugin->getParam('link.basic_dialog', 0) == 1) {            
            $config['basic_dialog'] = true;
            $config['file_browser'] = $plugin->getParam('file_browser', 1);
        }

        $settings['link'] = $config;
    }
}
