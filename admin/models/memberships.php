<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Member
* @copyright	Copyright (c) 2014 Norbert Kuemin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// import the Joomla modellist library
jimport('joomla.application.component.modellist');

/**
 * ClubManagementList Model
 */
class ClubManagementModelMemberships extends JModelList {
	public function __construct($config = array()) {
		if (!isset($config['filter_fields']) || empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'id', 'm.id',
				'type', 'm.type',
				'begin', 'm.begin',
				'end', 'm.end',
				'published', 'm.published',
				'createddate', 'm.createddate',
				'createdby', 'm.createdby'
			);
		}
		parent::__construct($config);
	}

	protected function populateState($ordering = null, $direction = null) {
		$app = JFactory::getApplication();
		// Adjust the context to support modal layouts.
		if ($layout = $app->input->get('layout')) {
			$this->context .= '.' . $layout;
		}
		$search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $search);
		// List state information.
		parent::populateState('m.end', 'asc');
	}

	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return      string  An SQL query
	 */
	protected function getListQuery() {
		// Create a new query object.           
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		// Select some fields from the hello table
		$query->select($db->quoteName(array('m.id', 'p.name', 'p.firstname', 'p.city', 'p.birthday', 'm.type', 'm.begin', 'm.end', 'm.published')))
			->from($db->quoteName('#__nokCM_memberships','m'))
			->join('LEFT', $db->quoteName('#__nokCM_persons', 'p').' ON ('.$db->quoteName('m.person_id').'='.$db->quoteName('p.id').')');
		// Filter by search in name.
		$search = $this->getState('filter.search');
		if (!empty($search)) {
			if (stripos($search, 'id:') === 0) {
				$query->where('m.id = '.(int) substr($search, 3));
			} else {
				$search = $db->quote('%'.$db->escape($search, true).'%');
				$query->where('(p.name LIKE '.$search.' OR p.firstname LIKE '.$search.')');
			}
		}
		// Add the list ordering clause.
		$orderColText = $this->state->get('list.ordering', 'm.end');
		$orderDirn = $this->state->get('list.direction', 'asc');
		$orderCols = explode(",",$orderColText);
		$orderEntry = array();
		foreach ($orderCols as $orderCol) {
			array_push($orderEntry,$db->escape($orderCol . ' ' . $orderDirn));
		}
		$query->order(implode(", ",$orderEntry));
		return $query;
	}

	/**
	 * Method to build an SQL query to load the list data.
	 *' 
	 * @return      string  An SQL query
	 */
	public function getFieldMapping() {
		return array (
			'name'=>'p.name',
			'firstname'=>'p.firstname',
			'address'=>'p.address',
			'city'=>'p.city',
			'birthday'=>'p.birthday',
			'person_id'=>'m.person_id',
			'type'=>'m.type',
			'begin'=>'m.begin',
			'end'=>'m.end',
			'published'=>'m.published',
			'category_alias'=>'c.alias',
			'category_extension'=>'c.extension',
			'createdby'=>'m.createdby',
			'createddate'=>'m.createddate'
		);
	}

	public function getExportColumns() {
		return array (
			'name','firstname','address','city','birthday', 
			'type','begin','end','published','category_extension','category_alias','createdby','createddate');
	}

	public function getImportPrimaryFields() {
		return array (
			'person_id'=>'person_id',
			'type'=>'type',
			'begin'=>'begin'
		);
	}

	public function getForeignKeys() {
		return array (
			'p' => array (
				'localKeyField' => 'person_id',
				'remoteTable' => '#__nokCM_persons',
				'remoteKeyField' => 'id',
				'remoteUniqueKey' => array('name', 'firstname', 'address', 'city', 'birthday')
			),
			'c' => array (
				'localKeyField' => 'catid',
				'remoteTable' => '#__categories',
				'remoteKeyField' => 'id',
				'remoteUniqueKey' => array('extension','alias')
			)
		);
	}

	public function getTableName() {
		return "#__nokCM_memberships";
	}

	public function getIdFieldName() {
		return "id";
	}


	public function getExportQuery($export_fields) {
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array_values($export_fields)))
			->from($db->quoteName($this->getTableName(),'m'))
			->join('LEFT', $db->quoteName('#__nokCM_persons', 'p').' ON ('.$db->quoteName('m.person_id').'='.$db->quoteName('p.id').')')
			->join('LEFT', $db->quoteName('#__categories', 'c').' ON ('.$db->quoteName('m.catid').'='.$db->quoteName('c.id').')');
		return $query;
	}

	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return      string  An SQL query
	 */
	public function getExportData() {
		return ClubManagementHelper::exportData($this);
	}

	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return      string  An SQL query
	 */
	public function saveImportData($data) {
		$header = array_shift($data);
		$this->saveImportData_stage($header, $data);
	}

	private function saveImportData_stage($header, $data) {
		ClubManagementHelper::importData($this, $header, $data);
	}
}
?>
