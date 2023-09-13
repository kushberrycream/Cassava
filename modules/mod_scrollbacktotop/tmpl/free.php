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
?>
<style>

<?php echo $customcss; ?>

</style>
	<script>
	jQuery(document).ready(function(){		
		jQuery("#cp-sbtt").cpsbtt({
			title:"<?php echo $title; ?>",
			ofset:"<?php echo $ofset; ?>",
			duration:"<?php echo $duration; ?>",
			button_theme: "<?php echo $button_theme; ?>",  // 12 different themes, from 1 to 12, if you do not want to use set 0 - set button color below
			button_shape:"circle", // circle, rounded, square,custom
			button_custom:"<?php echo $button_custom; ?>", // if button_shape is custom enter custom values
			button_effect: "zoominout",  // zoominout - fadeinout
			button_position: "<?php echo $button_position; ?>", // bottom-center, bottom-right, top-left, top-center, top-right, center-left, center-center, center-right
			icon_color:"#FFF", // if you set button_theme 0, you must set your own icon color here.
			icon_color_hover:"#FFF", // if you set button_theme 0, you must set your own icon color on mouse over here.
			icon_theme:"1", // 5 different button icon avalaible
			button_size:"medium" // small - medium - large - xlarge
		});	
	
	<?php echo $customjs; ?>
	
	});
	</script>	
	<!-- scroll back to top container -->
	<div id="cp-sbtt"></div>
