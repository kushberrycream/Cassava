<?php
/**
 * Joomla! component creativeimageslider
 *
 * @version $Id: sexypolls.php 2012-04-05 14:30:25 svn $
 * @author Creative-Solutions.net
 * @package Creative Image Slider
 * @subpackage com_creativeimageslider
 * @license GNU/GPL
 *
 */

// no direct access
defined('_JEXEC') or die('Restircted access');

jimport('joomla.application.component.modellist');

class CreativeimagesliderModelCreativesliders extends JModelList {
	
	/**
	 * Constructor.
	 *
	 * @param	array	An optional associative array of configuration settings.
	 * @see		JController
	 * @since	1.6
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
					'id', 'sp.id',
					'name', 'sp.name',
					'alias', 'sp.alias',
					'category_title',
					'template_title',
					'num_images',
					'question', 'sp.question',
					'published', 'sp.published',
					'checked_out', 'sp.checked_out',
					'checked_out_time', 'sp.checked_out_time',
					'access', 'sp.access', 'access_level',
					'ordering', 'sp.ordering',
					'featured', 'sp.featured',
					'publish_up', 'sp.publish_up',
					'publish_down', 'sp.publish_down'
			);
		}
	
		parent::__construct($config);
	}
	
	/**
	 * Method to get category options
	 *
	 */
	public function getCategory_options() {
		$db		= $this->getDbo();
		$sql = "SELECT `id`, `name` FROM `#__cis_categories` ";
    	$db->setQuery($sql);
    	return $opts = $db->loadObjectList();
	}
	
	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @return	void
	 * @since	1.6
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app = JFactory::getApplication();
	
		// Adjust the context to support modal layouts.
		if ($layout = $app->input->getVar('layout')) {
			$this->context .= '.'.$layout;
		}
	
		$search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);
	
		$published = $this->getUserStateFromRequest($this->context.'.filter.published', 'filter_published', '');
		$this->setState('filter.published', $published);
	
		$categoryId = $this->getUserStateFromRequest($this->context.'.filter.category_id', 'filter_category_id');
		$this->setState('filter.category_id', $categoryId);
		
		// List state information.
		parent::populateState('sp.name', 'asc');
	}
	
	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * This is necessary because the model is used by the component and
	 * different modules that might need different sets of data or different
	 * ordering requirements.
	 *
	 * @param	string		$id	A prefix for the store id.
	 *
	 * @return	string		A store id.
	 * @since	1.6
	 */
	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id	.= ':'.$this->getState('filter.search');
		$id	.= ':'.$this->getState('filter.published');
		$id	.= ':'.$this->getState('filter.category_id');
	
		return parent::getStoreId($id);
	}
	
	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return	JDatabaseQuery
	 * @since	1.6
	 */
	protected function getListQuery()
	{
		// Create a new query object.
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
		$user	= JFactory::getUser();
	
		// Select the required fields from the table.
		$query->select(
				$this->getState(
						'list.select',
						'sp.id, sp.name, sp.alias, sp.checked_out, sp.checked_out_time,sp.id_category, MAX(sp.id) AS max_id'.
						', sp.published, sp.access, sp.created, sp.ordering, sp.featured, sp.language'.
						', sp.publish_up, sp.publish_down'
				)
		);
		$query->from('#__cis_sliders AS sp');
		
		// Join over the answers.
		$query->select('COUNT(sa.id) AS num_images');
		$query->join('LEFT', '#__cis_images AS sa ON sa.id_slider=sp.id');
	
		// Join over the categories.
		$query->select('sc.name AS category_title, sc.id AS category_id');
		$query->join('LEFT', '#__cis_categories AS sc ON sc.id=sp.id_category');
	
		// Join over the templates.
		$query->select('st.name AS template_title, st.id AS template_id');
		$query->join('LEFT', '#__cis_templates AS st ON st.id=sp.id_template');
	
	
		// Filter by published state
		$published = $this->getState('filter.published');
		if (is_numeric($published)) {
			$query->where('sp.published = ' . (int) $published);
		}
		elseif ($published === '') {
			$query->where('(sp.published = 0 OR sp.published = 1)');
		}
	
		// Filter by a single or group of categories.
		$categoryId = $this->getState('filter.category_id');
		if (is_numeric($categoryId)) {
			$query->where('sp.id_category = '.(int) $categoryId);
		}
		elseif (is_array($categoryId)) {
			JArrayHelper::toInteger($categoryId);
			$categoryId = implode(',', $categoryId);
			$query->where('sp.id_category IN ('.$categoryId.')');
		}
	
		// Filter by search in name.
		$search = $this->getState('filter.search');
		if (!empty($search)) {
			if (stripos($search, 'id:') === 0) {
				$query->where('sp.id = '.(int) substr($search, 3));
			}
			else {
				$search = $db->Quote('%'.$db->escape($search, true).'%');
				$query->where('(sp.name LIKE '.$search.')');
			}
		}
	
		// Add the list ordering clause.
		$orderCol	= $this->state->get('list.ordering', 'sp.name');
		$orderDirn	= $this->state->get('list.direction', 'asc');
		/*
		if ($orderCol == 'a.ordering' || $orderCol == 'category_title') {
			$orderCol = 'c.title '.$orderDirn.', a.ordering';
		}
		*/
		$query->order($db->escape($orderCol.' '.$orderDirn));
		$query->group('sp.id');
	
		//echo nl2br(str_replace('#__','jos_',$query));
		return $query;
	}
}