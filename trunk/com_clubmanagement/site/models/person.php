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

defined('_JEXEC') or die;

// Include dependancy of the main model form
jimport('joomla.application.component.modelform');
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
// Include dependancy of the dispatcher
jimport('joomla.event.dispatcher');

class ClubManagementModelPerson extends JModelForm
{
	/**
	 * @since   1.6
	 */
	private $pk = '0';
	private $useAlias= true;
	protected $view_item = 'person';
	protected $_item = null;
	protected $_membershipItems = null;
	protected $_context = 'com_clubmanagement.person';
	protected $personFields = array (
			"person_id" => array('COM_CLUBMANAGEMENT_PERSONS_FIELD_ID_LABEL','p.id'),
			"person_salutation" => array('COM_CLUBMANAGEMENT_PERSONS_FIELD_SALUTATION_LABEL','p.salutation'),
			"person_firstname" => array('COM_CLUBMANAGEMENT_PERSONS_FIELD_FIRSTNAME_LABEL','p.firstname'),
			"person_middlename" => array('COM_CLUBMANAGEMENT_PERSONS_FIELD_MIDDLENAME_LABEL','p.middlename'),
			"person_name" => array('COM_CLUBMANAGEMENT_PERSONS_FIELD_NAME_LABEL','p.name'),
			"person_birthname" => array('COM_CLUBMANAGEMENT_PERSONS_FIELD_BIRTHNAME_LABEL','p.birthname'),
			"person_nickname" => array('COM_CLUBMANAGEMENT_PERSONS_FIELD_NICKNAME_LABEL','p.nickname'),
			"person_address" => array('COM_CLUBMANAGEMENT_PERSONS_FIELD_ADDRESS_LABEL','p.address'),
			"person_city" => array('COM_CLUBMANAGEMENT_PERSONS_FIELD_CITY_LABEL','p.city'),
			"person_zip" => array('COM_CLUBMANAGEMENT_PERSONS_FIELD_ZIP_LABEL','p.zip'),
			"person_state" => array('COM_CLUBMANAGEMENT_PERSONS_FIELD_STATE_LABEL','p.state'),
			"person_country" => array('COM_CLUBMANAGEMENT_PERSONS_FIELD_COUNTRY_LABEL','p.country'),
			"person_telephone" => array('COM_CLUBMANAGEMENT_PERSONS_FIELD_TELEPHONE_LABEL','p.telephone'),
			"person_mobile" => array('COM_CLUBMANAGEMENT_PERSONS_FIELD_MOBILE_LABEL','p.mobile'),
			"person_url" => array('COM_CLUBMANAGEMENT_PERSONS_FIELD_URL_LABEL','p.url'),
			"person_email" => array('COM_CLUBMANAGEMENT_PERSONS_FIELD_EMAIL_LABEL','p.email'),
			"user_username" => array('COM_CLUBMANAGEMENT_PERSONS_FIELD_USERNAME_LABEL','u.username'),
			"person_description" => array('COM_CLUBMANAGEMENT_PERSONS_FIELD_DESCRIPTION_LABEL','p.description'),
			"person_image" => array('COM_CLUBMANAGEMENT_PERSONS_FIELD_IMAGE_LABEL','p.image'),
			"person_birthday" => array('COM_CLUBMANAGEMENT_PERSONS_FIELD_BIRTHDAY_LABEL','p.birthday'),
			"person_deceased" => array('COM_CLUBMANAGEMENT_PERSONS_FIELD_DECEASED_LABEL','p.deceased'),
			"person_custom1" => array('COM_CLUBMANAGEMENT_PERSONS_FIELD_CUSTOM1_LABEL','p.custom1'),
			"person_custom2" => array('COM_CLUBMANAGEMENT_PERSONS_FIELD_CUSTOM2_LABEL','p.custom2'),
			"person_custom3" => array('COM_CLUBMANAGEMENT_PERSONS_FIELD_CUSTOM3_LABEL','p.custom3'),
			"person_custom4" => array('COM_CLUBMANAGEMENT_PERSONS_FIELD_CUSTOM4_LABEL','p.custom4'),
			"person_custom5" => array('COM_CLUBMANAGEMENT_PERSONS_FIELD_CUSTOM5_LABEL','p.custom5'),
			"person_hh_person_id" => array('COM_CLUBMANAGEMENT_PERSONS_FIELD_HH_PERSON_ID_LABEL','p.hh_person_id'),
			"person_hh_salutation_override" => array('COM_CLUBMANAGEMENT_PERSONS_FIELD_HH_SALUTATION_OVERWRITE_LABEL','p.hh_salutation_override'),
			"person_hh_name_override" => array('COM_CLUBMANAGEMENT_PERSONS_FIELD_HH_NAME_OVERWRITE_LABEL','p.hh_name_override'),
			"person_createdby" => array('COM_CLUBMANAGEMENT_PERSONS_FIELD_CREATEDBY_LABEL','p.createdby'),
			"person_createddate" => array('COM_CLUBMANAGEMENT_PERSONS_FIELD_CREATEDDATE_LABEL','p.createddate'),
			"person_modifiedby" => array('COM_CLUBMANAGEMENT_PERSONS_FIELD_MODIFIEDBY_LABEL','p.modifiedby'),
			"person_modifieddate" => array('COM_CLUBMANAGEMENT_PERSONS_FIELD_MODIFIEDDATE_LABEL','p.modifieddate')
		);
	protected $membershipFields = array (
			"member_id" => array('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_ID_LABEL','m.id'),
			"member_type" => array('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_TYPE_LABEL','m.type'),
			"member_begin" => array('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_BEGIN_LABEL','m.begin'),
			"member_end" => array('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_END_LABEL','m.end'),
			"member_beginyear" => array('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_BEGINYEAR_LABEL','YEAR(m.begin)'),
			"member_endyear" => array('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_ENDYEAR_LABEL','YEAR(m.end)'),
			"member_beginendyear" => array('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_BEGINENDYEAR_LABEL',"CONCAT(YEAR(m.begin),'-',IFNULL(YEAR(NULLIF(m.end,0)),''))"),
			"member_published" => array('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_PUBLISHED_LABEL','m.published'),
			"member_createdby" => array('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_CREATEDBY_LABEL','m.createdby'),
			"member_createddate" => array('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_CREATEDDATE_LABEL','m.createddate'),
			"member_modifiedby" => array('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_MODIFIEDBY_LABEL','m.modifiedby'),
			"member_modifieddate" => array('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_MODIFIEDDATE_LABEL','m.modifieddate')
		);
	protected $boardFields = array (
			"board_id" => array('COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_ID_LABEL','b.id'),
			"board_job" => array('COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_JOB_LABEL','b.job'),
			"board_sortorder" => array('COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_SORTORDER_LABEL','b.sortorder'),
			"board_begin" => array('COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_BEGIN_LABEL','b.begin'),
			"board_end" => array('COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_END_LABEL','b.end'),
			"board_beginyear" => array('COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_BEGINYEAR_LABEL','YEAR(b.begin)'),
			"board_endyear" => array('COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_ENDYEAR_LABEL','YEAR(b.end)'),
			"board_beginendyear" => array('COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_BEGINENDYEAR_LABEL',"CONCAT(YEAR(b.begin),'-',IFNULL(YEAR(NULLIF(b.end,0)),''))"),
			"board_published" => array('COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_PUBLISHED_LABEL','b.published'),
			"board_createdby" => array('COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_CREATEDBY_LABEL','b.createdby'),
			"board_createddate" => array('COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_CREATEDDATE_LABEL','b.createddate'),
			"board_modifiedby" => array('COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_MODIFIEDBY_LABEL','b.modifiedby'),
			"board_modifieddate" => array('COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_MODIFIEDDATE_LABEL','b.modifieddate')
		);

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since   1.6
	 */
	protected function populateState()
	{
		$app = JFactory::getApplication('site');

		// Load state from the request.
		$pk = $app->input->getInt('id');
		$this->setState('person.id', $pk);

		// Load the parameters.
		$params = $app->getParams();
		$this->setState('params', $params);

		$user = JFactory::getUser();

		if ((!$user->authorise('core.edit.state', 'com_clubmanagement')) &&  (!$user->authorise('core.edit', 'com_clubmanagement')))
		{
			$this->setState('filter.published', 1);
			$this->setState('filter.archived', 2);
		}
	}

	/**
	 * Method to get the contact form.
	 * The base form is loaded from XML and then an event is fired
	 *
	 * @param   array    $data      An optional array of data for the form to interrogate.
	 * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
	 * 
	 * @return  JForm  A JForm object on success, false on failure
	 * @since   1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_clubmanagement.person', 'person', array('control' => 'jform', 'load_data' => true));
		if (empty($form))
		{
			return false;
		}
		$pk = $this->getState('person.id');
		if (empty($pk)) $pk = $this->pk;
		$params = $this->getState('params');
		$person = $this->_item[$pk];
		$params->merge($person->params);
		return $form;
	}

	protected function loadFormData()
	{
		$data = (array) JFactory::getApplication()->getUserState('com_clubmanagement.person.data', array());
		$this->preprocessData('com_clubmanagement.person', $data);
		if (empty($data)) {
			$data = $this->getItem();
		}
		return $data;
	}

	/**
	 * Gets a contact
	 *
	 * @param   integer  $pk  Id for the contact
	 *
	 * @return mixed Object or null
	 */
	public function &getItem($pk = null)
	{
		if (empty($pk)) $pk = $this->getState('person.id');
		if (empty($pk)) $pk = $this->pk;
		if ($this->_item === null)
		{
			$this->_item = array();
		}

		if (!isset($this->_item[$pk]))
		{
			try
			{
				$db = $this->getDbo();
				$query = $db->getQuery(true);

				// Select some fields from the hello table
				$fields = array();
				foreach (array_keys($this->personFields) as $key)
				{
					$field = $this->personFields[$key];
					if ($this->useAlias) {
						array_push($fields,$field[1]." AS ".$key);
					} else {
						array_push($fields,$field[1]);
					}
				}

				$query->select($fields)
					->from($db->quoteName('#__nokCM_persons','p'))
					->join('LEFT', $db->quoteName('#__users', 'u').' ON ('.$db->quoteName('p.user_id').'='.$db->quoteName('u.id').')')
					->where('p.id = ' . (int) $pk);
				$db->setQuery($query);
				$data = $db->loadObject();
				$this->_item[$pk] = $data;
			}
			catch (Exception $e)
			{
				$this->setError($e);
				$this->_item[$pk] = false;
			}
		}

		return $this->_item[$pk];
	}

	public function &getMembershipItems($pk = null, $sort="")
	{
		$pk = (!empty($pk)) ? $pk : (int) $this->getState('person.id');
		if (!isset($this->_memberItems[$pk]))
		{
			try
			{
				$db = $this->getDbo();
				$query = $db->getQuery(true);

				// Select some fields from the hello table
				$fields = array();
				foreach (array_keys($this->membershipFields) as $key)
				{
					$field = $this->membershipFields[$key];
					array_push($fields,$field[1]." AS ".$key);
				}

				$query->select($fields)
					->from($db->quoteName('#__nokCM_memberships','m'))
					->where('m.person_id = ' . (int) $pk);
				if (!empty($sort)) {
					$query->order($sort);
				}
				$db->setQuery($query);
				$data = $db->loadObjectList();
				$this->_membershipItems[$pk] = $data;
			}
			catch (Exception $e)
			{
				$this->setError($e);
				$this->_membershipItems[$pk] = false;
			}
		}
		return $this->_membershipItems[$pk];
	}

	public function &getBoardItems($pk = null, $sort="")
	{
		$pk = (!empty($pk)) ? $pk : (int) $this->getState('person.id');
		if (!isset($this->_boardItems[$pk]))
		{
			try
			{
				$db = $this->getDbo();
				$query = $db->getQuery(true);

				// Select some fields from the hello table
				$fields = array();
				foreach (array_keys($this->boardFields) as $key)
				{
					$field = $this->boardFields[$key];
					array_push($fields,$field[1]." AS ".$key);
				}

				$query->select($fields)
					->from($db->quoteName('#__nokCM_board','b'))
					->where('b.person_id = ' . (int) $pk);
				if (!empty($sort)) {
					$query->order($sort);
				}
				$db->setQuery($query);
				$data = $db->loadObjectList();
				$this->_boardItems[$pk] = $data;			}
			catch (Exception $e)
			{
				$this->setError($e);
				$this->_boardItems[$pk] = false;
			}
		}
		return $this->_boardItems[$pk];
	}

        public function getPersonHeader($cols)
        {
		$fields = array();
		foreach ($cols as $col) {
			$field = $this->personFields[$col];
			array_push($fields,$field[0]);
		}
		return $fields;
	}

        public function getMembershipHeader($cols) {
		$fields = array();
		foreach ($cols as $col) {
			$field = $this->membershipFields[$col];
			array_push($fields,$field[0]);
		}
		return $fields;
	}

        public function getBoardHeader($cols) {
		$fields = array();
		foreach ($cols as $col) {
			$field = $this->boardFields[$col];
			array_push($fields,$field[0]);
		}
		return $fields;
	}

	public function getPersonIdListForCurrentUser() {
		$user = JFactory::getUser();
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		$query->select($db->quoteName("id"))
			->from($db->quoteName('#__nokCM_persons'))
			->where($db->quoteName("user_id").' = ' . (int) $user->id);
		$db->setQuery($query);
		$data = $db->loadObjectList();
		$result = array();
		foreach ($data as $row) {
			array_push($result,$row->id);
		}
		return $result;
	}

	public function getPersonItemsForCurrentUser($cols,$sort) {
		$user = JFactory::getUser();
		$db = $this->getDbo();
		$fields = array();
		foreach ($cols as $key)
		{
			$field = $this->personFields[$key];
			array_push($fields,$db->quoteName($field[1])." AS ".$key);
		}
		array_push($fields,$db->quoteName('p.id')." AS person_id");
		$query = $db->getQuery(true);
		$query->select($fields)
			->from($db->quoteName('#__nokCM_persons','p'))
			->where($db->quoteName("user_id").' = ' . (int) $user->id)
			->order($sort);
		$db->setQuery($query);
		return $db->loadObjectList();
	}

	public function translateFieldsToColumns($fields) {
		$result = array();
		foreach($fields as $field) {
			if ($this->personFields[$field]) {
				array_push($result,substr($this->personFields[$field][1],2));
			}
		}
		return $result;
	}

	public function setPk($pk) {
		$this->pk = $pk;
	}

	public function setUseAlias($useAlias) {
		$this->useAlias = $useAlias;
	}

	public function store() {
		parent::store();
	}

	public function updateCurrentUser($id, $data) {
		$user = JFactory::getUser();
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		$conditions = array(
			$db->quoteName("id").' = ' . $db->quote($id),
			$db->quoteName("user_id").' = ' . (int) $user->id
		);
		$fields = array();
		foreach (array_keys($data) as $key) {
			array_push($fields, $db->quoteName($key)." = ".$db->quote($data[$key]));
		}
		$query->update($db->quoteName('#__nokCM_persons'))
			->set($fields)
			->where($conditions);
		$db->setQuery($query);
		return $db->query();
	}
}
