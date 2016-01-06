<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Person
* @copyright	Copyright (c) 2014 Norbert Kümin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import the Joomla modellist library
jimport('joomla.application.component.modellist');

/**
 * ClubManagementList Model
 */
class ClubManagementModelPersons extends JModelList
{
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id', 'p.id',
				'name', 'p.name',
				'firstname', 'p.firstname',
				'address', 'p.address',
				'zip', 'p.zip',
				'city', 'p.city',
				'state', 'p.sate',
				'country', 'p.country',
				'createddate', 'p.createddate',
				'createdby', 'p.createdby'
			);

			$app = JFactory::getApplication();
		}

		parent::__construct($config);
	}

	protected function populateState($ordering = null, $direction = null)
	{
		$app = JFactory::getApplication();

		// Adjust the context to support modal layouts.
		if ($layout = $app->input->get('layout'))
		{
			$this->context .= '.' . $layout;
		}

		$search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		// List state information.
		parent::populateState('p.name', 'asc');
	}

        /**
         * Method to build an SQL query to load the list data.
         *
         * @return      string  An SQL query
         */
        protected function getListQuery()
        {
                // Create a new query object.           
                $db = JFactory::getDBO();
                $query = $db->getQuery(true);

                // Select some fields from the hello table
                $query
                    ->select($db->quoteName(array('p.id', 'p.name', 'p.firstname', 'p.address', 'p.zip', 'p.city', 'p.state', 'p.country')))
                    ->from($db->quoteName('#__nokCM_persons','p'));
 
		// special filtering (houshold, excludeid).
		$whereExtList = array();
		$app = JFactory::getApplication();
		if ($household = $app->input->get('hh'))
		{
			array_push($whereExtList,$db->quoteName("p.hh_person_id")." IS NULL");
		}
		if ($excludeId = $app->input->get('excludeid'))
		{
			array_push($whereExtList,"NOT ".$db->quoteName("p.id")." = ".$excludeId);
		}
		$whereExt = implode(" AND ",$whereExtList);

		// Filter by search in name.
		$search = $this->getState('filter.search');
		if (!empty($search))
		{
			if (!empty($whereExt)) $whereExt = " AND ".$whereExt;
			if (stripos($search, 'id:') === 0)
			{
				$query->where('p.id = ' . (int) substr($search, 3).$whereExt);
			}
			else
			{
				$search = $db->quote('%' . $db->escape($search, true) . '%');
				$query->where('(p.name LIKE ' . $search . ' OR p.firstname LIKE ' . $search . ')'.$whereExt);
			}
		} else {
			if (!empty($whereExt))
			{
				$query->where($whereExt);
			}
		}

		// Add the list ordering clause.
		$orderColText = $this->state->get('list.ordering', 'p.name,p.firstname');
		$orderDirn = $this->state->get('list.direction', 'asc');
		$orderCols = explode(",",$orderColText);
		$orderEntry = array();
		foreach ($orderCols as $orderCol)
		{
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
        public function getFieldMapping()
        {
		return array(
			'salutation'=>'p.salutation',
			'name'=>'p.name',
			'birthname'=>'p.birthname',
			'firstname'=>'p.firstname',
			'middlename'=>'p.middlename',
			'nickname'=>'p.nickname',
			'address'=>'p.address',
			'zip'=>'p.zip',
			'city'=>'p.city',
			'state'=>'p.state',
			'country'=>'p.country',
			'hh_person_id'=>'p.hh_person_id',
			'hh_salutation_override'=>'p.hh_salutation_override',
			'hh_name_override'=>'p.hh_name_override',
			'hh_name'=>'hh.name',
			'hh_firstname'=>'hh.firstname',
			'hh_address'=>'hh.address',
			'hh_city'=>'hh.city',
			'hh_birthday'=>'hh.birthday', 
			'birthday'=>'p.birthday',
			'deceased'=>'p.deceased',
			'telephone'=>'p.telephone',
			'mobile'=>'p.mobile',
			'email'=>'p.email',
			'url'=>'p.url',
			'image'=>'p.image',
			'user_id'=>'p.user_id', 
			'username'=>'u.username', 
			'custom1'=>'p.custom1',
			'custom2'=>'p.custom2',
			'custom3'=>'p.custom3',
			'custom4'=>'p.custom4',
			'custom5'=>'p.custom5',
			'description'=>'p.description',
			'createdby'=>'p.createdby',
			'createddate'=>'p.createddate'
		);
	}

        public function getExportColumns()
        {
		return array(
			'salutation', 'name', 'birthname', 'firstname', 'middlename', 'nickname', 'address', 'zip', 'city', 'state', 'country',
			'hh_salutation_override','hh_name_override','hh_name','hh_firstname','hh_address','hh_city','hh_birthday', 
			'birthday','deceased','telephone','mobile','email','url','image','username', 
			'custom1','custom2','custom3','custom4','custom5','description','createdby','createddate');
	}

        public function getImportPrimaryFields()
        {
		return array(
			'name'=>'name',
			'firstname'=>'firstname',
			'address'=>'address',
			'city'=>'city',
			'birthday'=>'birthday'
		);
	}

        public function getForeignKeys()
        {
		return array(
			'hh' => array (
				'localKeyField' => 'hh_person_id',
				'remoteTable' => '#__nokCM_persons',
				'remoteKeyField' => 'id',
				'remoteUniqueKey' => array('name', 'firstname', 'address', 'city', 'birthday')
			),
			'u' => array (
				'localKeyField' => 'user_id',
				'remoteTable' => '#__users',
				'remoteKeyField' => 'id',
				'remoteUniqueKey' => array('username')
			)
		);
	}

        public function getTableName()
        {
		return "#__nokCM_persons";
	}

        public function getIdFieldName()
        {
		return "id";
	}

        public function getExportQuery($export_fields)
        {
                $db = JFactory::getDBO();
                $query = $db->getQuery(true);
                $query
                	->select($db->quoteName(array_values($export_fields)))
                	->from($db->quoteName($this->getTableName(),'p'))
			->join('LEFT', $db->quoteName('#__nokCM_persons', 'hh').' ON ('.$db->quoteName('p.hh_person_id').'='.$db->quoteName('hh.id').')')
			->join('LEFT', $db->quoteName('#__users', 'u').' ON ('.$db->quoteName('p.user_id').'='.$db->quoteName('u.id').')');
		return $query;
	}

        /**
         * Method to build an SQL query to load the list data.
         *
         * @return      string  An SQL query
         */
        public function getExportData()
        {
		return ClubManagementHelper::exportData($this);
	}

        /**
         * Method to build an SQL query to load the list data.
         *
         * @return      string  An SQL query
         */
        public function saveImportData($data)
	{
		$header = array_shift($data);
		$data_stage1 = array();
		$data_stage2 = array();
		foreach ($data as $entry)
		{
			$row = ClubManagementHelper::getNamedArray($header, $entry);
			$hh_key = $row['hh_name'].$row['hh_firstname'].$row['hh_address'].$row['hh_city'].$row['hh_birthday'];
			if ($hh_key == '')
			{
				array_push($data_stage1, $entry);
			}
			else
			{
				array_push($data_stage2, $entry);
			}
		}
		$this->saveImportData_stage($header, $data_stage1);
		$this->saveImportData_stage($header, $data_stage2);
	}

        private function saveImportData_stage($header, $data)
        {
		ClubManagementHelper::importData($this, $header, $data);
	}

}
?>
