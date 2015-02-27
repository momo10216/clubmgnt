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
// Include dependancy of the component helper
jimport('joomla.application.component.helper');

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

	private function getPersonFields() {
		$params = JComponentHelper::getParams('com_clubmanagement');
		return array (
			"person_id" => array(JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_ID_LABEL',true),'`p`.`id`'),
			"person_salutation" => array(JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_SALUTATION_LABEL',true),'`p`.`salutation`'),
			"person_firstname" => array(JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_FIRSTNAME_LABEL',true),'`p`.`firstname`'),
			"person_middlename" => array(JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_MIDDLENAME_LABEL',true),'`p`.`middlename`'),
			"person_name" => array(JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_NAME_LABEL',true),'`p`.`name`'),
			"person_birthname" => array(JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_BIRTHNAME_LABEL',true),'`p`.`birthname`'),
			"person_nickname" => array(JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_NICKNAME_LABEL',true),'`p`.`nickname`'),
			"person_nickfirstname" => array(JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_NICKFIRSTNAME_LABEL',true),"IFNULL(NULLIF(`p`.`nickname`,''),`p`.`firstname`)"),
			"person_address" => array(JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_ADDRESS_LABEL',true),'`p`.`address`'),
			"person_city" => array(JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_CITY_LABEL',true),'`p`.`city`'),
			"person_zip" => array(JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_ZIP_LABEL',true),'`p`.`zip`'),
			"person_state" => array(JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_STATE_LABEL',true),'`p`.`state`'),
			"person_country" => array(JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_COUNTRY_LABEL',true),'`p`.`country`'),
			"person_telephone" => array(JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_TELEPHONE_LABEL',true),'`p`.`telephone`'),
			"person_mobile" => array(JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_MOBILE_LABEL',true),'`p`.`mobile`'),
			"person_url" => array(JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_URL_LABEL',true),'`p`.`url`'),
			"person_email" => array(JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_EMAIL_LABEL',true),'`p`.`email`'),
			"user_username" => array(JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_USERNAME_LABEL',true),'`u`.`username`'),
			"person_description" => array(JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_DESCRIPTION_LABEL',true),'`p`.`description`'),
			"person_image" => array(JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_IMAGE_LABEL',true),'`p`.`image`'),
			"person_birthday" => array(JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_BIRTHDAY_LABEL',true),'`p`.`birthday`'),
			"person_nextbirthday" => array(JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_NEXT_BIRTHDAY_LABEL',true),'IF(DATE_ADD(`p`.`birthday`, INTERVAL (YEAR(NOW()) - YEAR(`p`.`birthday`)) YEAR) < CURDATE(),DATE_ADD(p.`birthday`, INTERVAL (YEAR(NOW()) - YEAR(`p`.`birthday`) + 1) YEAR),DATE_ADD(`p`.`birthday`, INTERVAL (YEAR(NOW()) - YEAR(`p`.`birthday`)) YEAR))'),
			"person_deceased" => array(JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_DECEASED_LABEL',true),'`p`.`deceased`'),
			"person_custom1" => array($params->get('custom1'),'`p`.`custom1`'),
			"person_custom2" => array($params->get('custom2'),'`p`.`custom2`'),
			"person_custom3" => array($params->get('custom3'),'`p`.`custom3`'),
			"person_custom4" => array($params->get('custom4'),'`p`.`custom4`'),
			"person_custom5" => array($params->get('custom5'),'`p`.`custom5`'),
			"person_hh_person_id" => array(JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_HH_PERSON_ID_LABEL',true),'`p`.`hh_person_id`'),
			"person_hh_salutation_override" => array(JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_HH_SALUTATION_OVERWRITE_LABEL',true),'`p`.`hh_salutation_override`'),
			"person_hh_name_override" => array(JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_HH_NAME_OVERWRITE_LABEL',true),'`p`.`hh_name_override`'),
			"person_createdby" => array(JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_CREATEDBY_LABEL',true),'`p`.`createdby`'),
			"person_createddate" => array(JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_CREATEDDATE_LABEL',true),'`p`.`createddate`'),
			"person_modifiedby" => array(JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_MODIFIEDBY_LABEL',true),'`p`.`modifiedby`'),
			"person_modifieddate" => array(JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_MODIFIEDDATE_LABEL',true),'`p`.`modifieddate`')
		);
	}

	private function getMembershipFields() {
		return array (
			"member_id" => array(JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_ID_LABEL',true),'`m`.`id`'),
			"member_type" => array(JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_TYPE_LABEL',true),'`m`.`type`'),
			"member_begin" => array(JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_BEGIN_LABEL',true),'`m`.`begin`'),
			"member_end" => array(JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_END_LABEL',true),'`m`.`end`'),
			"member_beginyear" => array(JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_BEGINYEAR_LABEL',true),'YEAR(`m`.`begin`)'),
			"member_endyear" => array(JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_ENDYEAR_LABEL',true),'YEAR(`m`.`end`)'),
			"member_beginendyear" => array(JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_BEGINENDYEAR_LABEL',true),"CONCAT(YEAR(`m`.`begin`),'-',IFNULL(YEAR(NULLIF(`m`.`end`,0)),''))"),
			"member_published" => array(JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_PUBLISHED_LABEL',true),'`m`.`published`'),
			"member_createdby" => array(JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_CREATEDBY_LABEL',true),'`m`.`createdby`'),
			"member_createddate" => array(JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_CREATEDDATE_LABEL',true),'`m`.`createddate`'),
			"member_modifiedby" => array(JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_MODIFIEDBY_LABEL',true),'`m`.`modifiedby`'),
			"member_modifieddate" => array(JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_MODIFIEDDATE_LABEL',true),'`m`.`modifieddate`')
		);
	}

	private function getBoardFields() {
		return array (
			"board_id" => array(JText::_('COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_ID_LABEL',true),'`b`.`id`'),
			"board_job" => array(JText::_('COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_JOB_LABEL',true),'`b`.`job`'),
			"board_sortorder" => array(JText::_('COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_SORTORDER_LABEL',true),'`b`.`sortorder`'),
			"board_begin" => array(JText::_('COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_BEGIN_LABEL',true),'`b`.`begin`'),
			"board_end" => array(JText::_('COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_END_LABEL',true),'`b`.`end`'),
			"board_beginyear" => array(JText::_('COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_BEGINYEAR_LABEL',true),'YEAR(`b`.`begin`)'),
			"board_endyear" => array(JText::_('COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_ENDYEAR_LABEL',true),'YEAR(`b`.`end`)'),
			"board_beginendyear" => array(JText::_('COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_BEGINENDYEAR_LABEL',true),"CONCAT(YEAR(`b`.`begin`),'-',IFNULL(YEAR(NULLIF(`b`.`end`,0)),''))"),
			"board_published" => array(JText::_('COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_PUBLISHED_LABEL',true),'`b`.`published`'),
			"board_createdby" => array(JText::_('COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_CREATEDBY_LABEL',true),'`b`.`createdby`'),
			"board_createddate" => array(JText::_('COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_CREATEDDATE_LABEL',true),'`b`.`createddate`'),
			"board_modifiedby" => array(JText::_('COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_MODIFIEDBY_LABEL',true),'`b`.`modifiedby`'),
			"board_modifieddate" => array(JText::_('COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_MODIFIEDDATE_LABEL',true),'`b`.`modifieddate`')
		);
	}

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
				$allFields = $this->getPersonFields();
				foreach (array_keys($allFields) as $key)
				{
					$field = $allFields[$key];
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
				$allFields = $this->getMembershipFields();
				foreach (array_keys($allFields) as $key)
				{
					$field = $allFields[$key];
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
				$allFields = $this->getBoardFields();
				foreach (array_keys($allFields) as $key)
				{
					$field = $allFields[$key];
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
		$allFields = $this->getPersonFields();
		foreach ($cols as $col) {
			$field = $allFields[$col];
			array_push($fields,$field[0]);
		}
		return $fields;
	}

        public function getMembershipHeader($cols) {
		$fields = array();
		$allFields = $this->getMembershipFields();
		foreach ($cols as $col) {
			$field = $allFields[$col];
			array_push($fields,$field[0]);
		}
		return $fields;
	}

        public function getBoardHeader($cols) {
		$fields = array();
		$allFields = $this->getBoardFields();
		foreach ($cols as $col) {
			$field = $allFields[$col];
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
		$allFields = $this->getPersonFields();
		foreach ($cols as $key)
		{
			$field = $allFields[$key];
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

	public function translateFieldsToColumns($fields, $removePrefix=true) {
		$result = array();
		$allFields = $this->getPersonFields();
		foreach($fields as $field) {
			if ($allFields[$field]) {
				if ($removePrefix) {
					$resultField = str_replace('`p`.', '' , $allFields[$field][1]);
					$resultField = str_replace('`m`.', '' , $resultField);
					$resultField = str_replace('`b`.', '' , $resultField);
					$resultField = str_replace('`u`.', '' , $resultField);
					$resultField = str_replace('`', '' , $resultField);
					array_push($result,$resultField);
				} else {
					array_push($result,$allFields[$field][1]);
				}
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
?>
