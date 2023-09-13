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

$joomla4 = version_compare(JVERSION, '4', '>=') ? true : false;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Session\Session;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('dropdown.init');
JHtml::_('formbehavior.chosen', 'select');
	
if($joomla4) {
	$wa = $this->document->getWebAssetManager();
	$wa->useScript('multiselect');
}

if(true) {

$user		= JFactory::getUser();
$userId		= $user->get('id');
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
$archived	= $this->state->get('filter.published') == 2 ? true : false;
$trashed	= $this->state->get('filter.published') == -2 ? true : false;
$saveOrder	= $listOrder == 'sa.ordering';

if ($saveOrder)
{
	if($joomla4) {
		$saveOrderingUrl = 'index.php?option=com_creativeimageslider&task=creativeimages.saveOrderAjax&tmpl=component&' . Session::getFormToken() . '=1';
		HTMLHelper::_('draggablelist.draggable');
	} else {
		$saveOrderingUrl = 'index.php?option=com_creativeimageslider&task=creativeimages.saveOrderAjax&tmpl=component';
		JHtml::_('sortablelist.sortable', 'articleList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
	}
}
$sortFields = $this->getSortFields();

if($joomla4) { // Bootstrap 4
	$classes_row = 'row';
	$classes_col = 'col-md-';
} else { // Boostrap 2.3.2
	$classes_row = 'row-fluid';
	$classes_col = 'span';
}

if(!J4) {?>
<script type="text/javascript">
	Joomla.orderTable = function() {
		table = document.getElementById("sortTable");
		direction = document.getElementById("directionTable");
		order = table.options[table.selectedIndex].value;
		if (order != '<?php echo $listOrder; ?>') {
			dirn = 'asc';
		} else {
			dirn = direction.options[direction.selectedIndex].value;
		}
		Joomla.tableOrdering(order, dirn, '');
	}
</script>
<?php }?>
<form action="<?php echo JRoute::_('index.php?option=com_creativeimageslider'); ?>" method="post" name="adminForm" id="adminForm">
<div class="<?php echo $classes_row; ?>">
<?php if(!empty( $this->sidebar)): ?>
	<div id="j-sidebar-container" class="<?php echo $classes_col;?>2">
		<?php echo $this->sidebar; ?>
	</div>
	<?php if(J4) echo '<div class="'.$classes_col.'10">'; ?>
	<div id="j-main-container" class="j-main-container <?php if(!J4) echo $classes_col.'10';?>">
<?php else : ?>
	<div id="j-main-container">
<?php endif;?>
		<div id="filter-bar" class="btn-toolbar" <?php if($joomla4) echo 'style="padding: 10px 10px 0 10px;display: block;height: 68px;"'?>>
			<div class="filter-search btn-group pull-left">
				<label for="filter_search" class="element-invisible"><?php echo JText::_('COM_CREATIVEIMAGESLIDER_SEARCH_BY_NAME');?></label>
				<input type="text" name="filter_search" id="filter_search" placeholder="<?php echo JText::_('COM_CREATIVEIMAGESLIDER_SEARCH_BY_NAME'); ?>" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_CREATIVEIMAGESLIDER_SEARCH_BY_NAME'); ?>" <?php if($joomla4) echo 'style="height:46px;"'?> />
			</div>
			<div class="btn-group pull-left">
				<button class="btn btn-secondary hasTooltip" type="submit" title="<?php echo JText::_('COM_CREATIVEIMAGESLIDER_SEARCH'); ?>"><i class="icon-search"></i></button>
				<button class="btn btn-secondary hasTooltip" type="button" title="<?php echo JText::_('COM_CREATIVEIMAGESLIDER_RESET'); ?>" onclick="document.getElementById('filter_search').value='';this.form.submit();"><i class="icon-remove"></i></button>
			</div>
			<div class="btn-group pull-right hidden-phone">
				<label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC');?></label>
				<?php echo $this->pagination->getLimitBox(); ?>
			</div>
			<div class="btn-group pull-right hidden-phone">
				<label for="directionTable" class="element-invisible"><?php echo JText::_('JFIELD_ORDERING_DESC');?></label>
				<select name="directionTable" id="directionTable" class="input-medium" onchange="<?php if(J4){?>var el1 = document.getElementById('sortTable');var el2 = document.getElementById('directionTable');var val1 = el1.options[el1.selectedIndex].value;var val2 = el2.options[el2.selectedIndex].value;Joomla.tableOrdering(val1,val2,'');<?php }else{?>Joomla.orderTable()<?php }?>">
					<option value=""><?php echo JText::_('JFIELD_ORDERING_DESC');?></option>
					<option value="asc" <?php if ($listDirn == 'asc') echo 'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_ASCENDING');?></option>
					<option value="desc" <?php if ($listDirn == 'desc') echo 'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_DESCENDING');?></option>
				</select>
			</div>
			<div class="btn-group pull-right">
				<label for="sortTable" class="element-invisible"><?php echo JText::_('JGLOBAL_SORT_BY');?></label>
				<select name="sortTable" id="sortTable" class="input-medium" onchange="<?php if(J4){?>var el1 = document.getElementById('sortTable');var el2 = document.getElementById('directionTable');var val1 = el1.options[el1.selectedIndex].value;var val2 = el2.options[el2.selectedIndex].value;Joomla.tableOrdering(val1,val2,'');<?php }else{?>Joomla.orderTable()<?php }?>">
					<option value=""><?php echo JText::_('JGLOBAL_SORT_BY');?></option>
					<?php echo JHtml::_('select.options', $sortFields, 'value', 'text', $listOrder);?>
				</select>
			</div>
		</div>
		<div class="clearfix"> </div>
		<table class="table table-striped" id="articleList">
			<thead>
				<tr>
					<th width="1%" class="nowrap center hidden-phone">
						<?php echo JHtml::_('grid.sort', '<i class="icon-menu-2"></i>', 'sa.ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING'); ?>
					</th>
					<th width="1%" class="hidden-phone">
						<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
					</th>
					<th width="1%" style="min-width:55px" class="nowrap center">
						<?php echo JHtml::_('grid.sort', 'JSTATUS', 'sa.published', $listDirn, $listOrder); ?>
					</th>
					<th>
						<?php echo JHtml::_('grid.sort', 'COM_CREATIVEIMAGESLIDER_NAME', 'sa.name', $listDirn, $listOrder); ?>
					</th>
					<th width="30%">
						<?php echo JHtml::_('grid.sort', 'COM_CREATIVEIMAGESLIDER_SLIDER', 'slider_name', $listDirn, $listOrder); ?>
					</th>
					<th width="1%" class="nowrap center hidden-phone">
						<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'sa.id', $listDirn, $listOrder); ?>
					</th>
				</tr>
			</thead>
			<tbody <?php if ($saveOrder && $joomla4) :?> class="js-draggable" data-url="<?php echo $saveOrderingUrl; ?>" data-direction="<?php echo strtolower($listDirn); ?>" data-nested="false"<?php endif; ?>>
			<?php
			$n = count($this->items);
			foreach ($this->items as $i => $item) :
				$ordering	= $listOrder == 'sa.ordering';
				?>
				<tr class="row<?php echo $i % 2; ?>" sortable-group-id="7" data-draggable-group="7">
					<td class="order nowrap center hidden-phone" valign="middle" style="vertical-align: middle;">
						<?php
							$disableClassName = '';
							$disabledLabel	  = '';
							if (!$saveOrder) :
								$disabledLabel    = JText::_('JORDERINGDISABLED');
								$disableClassName = 'inactive tip-top';
							endif; ?>
							<span class="sortable-handler hasTooltip<?php echo $disableClassName?>" title="<?php echo $disabledLabel?>">
								<i class="icon-menu"></i>
							</span>
							<input type="text" style="display:none" name="order[]" size="5"
							value="<?php echo $item->ordering;?>" class="width-20 text-area-order " />
					</td>
					<td class="center hidden-phone" valign="middle" style="vertical-align: middle;">
						<?php echo JHtml::_('grid.id', $i, $item->id); ?>
					</td>
					<td class="center" valign="middle" style="vertical-align: middle;">
						<?php echo JHtml::_('jgrid.published', $item->published, $i, 'creativeimages.', true, 'cb', $item->publish_up, $item->publish_down); ?>
					</td>
					<td class="nowrap has-context" valign="middle" style="vertical-align: middle;">
						<div class="pull-left">
							<a href="<?php echo JRoute::_('index.php?option=com_creativeimageslider&task=creativeimage.edit&id='.(int) $item->id); ?>">
								<?php echo $this->escape($item->name); ?>
								<?php $img_name =  $item->img_name != '' ? JURI::base(true) . '/../' . $item->img_name : $item->img_url;?>
								<?php if($img_name != '') {?><img src="<?php echo $img_name;?>" style="height: 35px;margin-left: 20px;border: 0;" /><?php }?>
							</a>
						</div>
					</td>
					<td class="nowrap has-context" valign="middle" style="vertical-align: middle;">
						<div class="pull-left">
							<a href="<?php echo JRoute::_('index.php?option=com_creativeimageslider&task=creativeslider.edit&id='.(int) $item->slider_id); ?>">
								<?php echo $this->escape($item->slider_name); ?>
							</a>
						</div>
					</td>
					<td align="center hidden-phone" valign="middle" style="vertical-align: middle;">
						<?php echo $item->id; ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="7">
						<?php echo $this->pagination->getListFooter(); ?>
					</td>
				</tr>
			</tfoot>
		</table>
		<input type="hidden" name="view" value="creativeimages" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</div>
</form>
<?php include (JPATH_BASE.'/components/com_creativeimageslider/helpers/footer.php'); ?>
<?php }?>