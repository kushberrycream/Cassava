<?php
/**
 * @package         Tabs & Accordions
 * @version         1.5.0
 * 
 * @author          Peter van Westen <info@regularlabs.com>
 * @link            https://regularlabs.com
 * @copyright       Copyright © 2023 Regular Labs All Rights Reserved
 * @license         GNU General Public License version 2 or later
 */

use RegularLabs\Library\HtmlTag as RL_HtmlTag;

defined('JPATH_BASE') or die;

/**
 * Layout variables
 * -----------------
 *
 * @var   object $displayData
 */

$set = $displayData;

$layout_path = JPATH_PLUGINS . '/system/tabsaccordions/layouts';

$attributes      = [
];
$data_attributes = [
    'element' => 'container',
    'state'   => 'initial', // @todo: set to null if pre-load styling is switched off
];
$data_attributes = array_merge($data_attributes, (array) $set->data);

$attributes = trim(
    RL_HtmlTag::flattenAttributes($attributes)
    . ' ' . RL_HtmlTag::flattenAttributes($data_attributes, 'data-rlta-')
);
?>
<div <?php echo $attributes; ?>>
