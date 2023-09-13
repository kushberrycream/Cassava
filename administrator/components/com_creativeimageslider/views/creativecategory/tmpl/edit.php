<?php
/**
 * Joomla! component creativeimageslider
 *
 * @version $Id: default.php 2012-04-05 14:30:25 svn $
 * @author Creative-Solutions.net
 * @package Creative Image Slider
 * @subpackage com_creativeimageslider
 * @license GNU/GPL
 *
 */

// no direct access
defined('_JEXEC') or die('Restircted access');

if(!J4) {
	JHtml::_('behavior.formvalidation');
	JHtml::_('behavior.tooltip');
}
else {
	$wa = $this->document->getWebAssetManager();
	$wa->useScript('keepalive')
		->useScript('form.validate');
}
JHtml::_('formbehavior.chosen', 'select');
?>
<script type="text/javascript">
<?php if(!J4) {?>
Joomla.submitbutton = function(task) {
	var form = document.adminForm;
	if (task == 'creativecategory.cancel') {
		submitform( task );
	}
	else {
		if (form.jform_name.value != ""){
			form.jform_name.style.border = "1px solid green";
		} 
		
		if (form.jform_name.value == ""){
			form.jform_name.style.border = "1px solid red";
			form.jform_name.focus();
		} 
		else {
			submitform( task );
		}
	}
	
}
<?php }?>
</script>
<?php if(JV == 'j3') {?>
<?php 
?>
<form action="<?php echo JRoute::_('index.php?option=com_creativeimageslider&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate form-horizontal">
	<div class="row-fluid">
		<!-- Begin Newsfeed -->
		<div class="span10 form-horizontal">
			<fieldset>
				<div class="tab-content">
					<div class="tab-pane active" id="details">
						<div class="control-group">
							<?php foreach($this->form->getFieldset() as $field): ?>
								<div class="control-label"><?php echo $field->label;?></div>
								<div class="controls"><?php echo $field->input;?></div>
								<div style="clear: both;height: 8px;">&nbsp;</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</fieldset>
		</div>
	</div>
<input type="hidden" name="task" value="creativecategory.edit" />
<?php echo JHtml::_('form.token'); ?>
</form>
<?php include (JPATH_BASE.'/components/com_creativeimageslider/helpers/footer.php'); ?>
<?php }?>
