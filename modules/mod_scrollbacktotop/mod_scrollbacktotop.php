<?php
/**
* @package 		mod_scrollbacktotop - Scroll Back To Top
* @version		1.0.2
* @created		Oct 2022
* @author		CodePlazza
* @email		support@codeplazza.com
* @website		https://www.codeplazza.com/
* @support		https://www.codeplazza.com/support.html
* @copyright	Copyright (C) 2018 - Today CodePlazza. All rights reserved.
* @license		GNU General Public License version 2 and above
*/
	defined('_JEXEC') or die;

	// modules base location
	$site_uri = JUri::base();
	$module_uri = $site_uri.'modules/mod_scrollbacktotop/';

		$document = JFactory::getDocument();
		// add module's stylesheet to <head>
		$document->addStyleSheet($module_uri.'assets/plugin_assets/css/style.css');
		// add module's js file to <head>
		// Field : Load jQuery 
		$loadj 			= $params->get('loadj', '0');		
		if($loadj){
		$document->addScript($module_uri.'assets/plugin_assets/js/jquery.js');
		}

		$document->addScript($module_uri.'assets/plugin_assets/js/jquery-cpsbtt.js');
		
		// register Helper Class from helper.php 
		JLoader::register('ModScrollbacktotopHelper', __DIR__ . '/helper.php');
		// Assign getData Method of Helper Class to $get_data variable
		$get_data	= ModScrollbacktotopHelper::getData($params);

		// assign parameters to variables 
		$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8');
		// Field : Load jQuery 
		$loadj 			= $params->get('loadj', '0');
		// Field : Title 
		$title 			= $params->get('title', 'Scroll Back to Top');
		// Field : Offset 
		$ofset 			= $params->get('ofset', '20');
		// Field : Duration 
		$duration 			= $params->get('duration', '750');
		// Field : Use Theme 
		$use_theme 			= $params->get('use_theme', '1');
		// Field : Button Theme 
		$button_theme 			= $params->get('button_theme', '1');
		// Field : Button Color 
		$button_color 			= $params->get('button_color', '#B1B520');
		// Field : Button Color Hover 
		$button_color_hover 			= $params->get('button_color_hover', '#7f8206');
		// Field : Button Border Color 
		$button_border_color 			= $params->get('button_border_color', '#FFFFFF');
		// Field : Button Border Color Hover 
		$button_border_color_hover 			= $params->get('button_border_color_hover', '#FFFFFF');
		// Field : Button Border Thickness 
		$button_border_thickness 			= $params->get('button_border_thickness', 'Some Value');
		// Field : Button Shape 
		$button_shape 			= $params->get('button_shape', 'circle');
		// Field : Button Custom Shape 
		$button_custom 			= $params->get('button_custom', '24px 0 24px 0');
		// Field : Button Effect 
		$button_effect 			= $params->get('button_effect', 'zoominout');
		// Field : Button Position 
		$button_position 			= $params->get('button_position', 'bottom-right');
		// Field : Icon Theme 
		$icon_theme 			= $params->get('icon_theme', '1');
		// Field : Icon Color 
		$icon_color 			= $params->get('icon_color', '#FFFFFF');
		// Field : Icon Color Hover 
		$icon_color_hover 			= $params->get('icon_color_hover', '#EFEFEF');
		// Field : Button 
		$button_size 			= $params->get('button_size', 'medium');
		// Field : Custom CSS 
		$customcss 			= $params->get('customcss', '/* you can add css code if it is necessary */');
		// Field : Custom JS 
		$customjs 			= $params->get('customjs', '// You can add js code if it is necessary');

		// Load Layout 
		require JModuleHelper::getLayoutPath('mod_scrollbacktotop', $params->get('layout', 'free'));
