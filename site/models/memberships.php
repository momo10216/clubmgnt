<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Member
* @copyright	Copyright (c) 2014 Norbert Kümin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/
defined('_JEXEC') or die;
jimport('joomla.application.component.helper');
class ClubManagementModelMemberships extends JModelList {
	public $_context = 'com_clubmanagement.memberships';
	protected $_extension = 'com_clubmanagement';
	protected $paramsComponent;
	protected $paramsMenuEntry;
	private $_items = null;

	private function getFields() {
		$params = JComponentHelper::getParams('com_clubmanagement');
		return array (
			"member_id" => array(JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_ID_LABEL',true),'`m`.`id`'),
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
			"member_type" => array(JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_TYPE_LABEL',true),'`m`.`type`'),
			"member_begin" => array(JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_BEGIN_LABEL',true),'`m`.`begin`'),
			"member_end" => array(JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_END_LABEL',true),'`m`.`end`'),
			"member_beginyear" => array(JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_BEGINYEAR_LABEL',true),'YEAR(`m`.`begin`)'),
			"member_endyear" => array(JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_ENDYEAR_LABEL',true),'YEAR(`m`.`end`)'),
			"member_beginendyear" => array(JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_BEGINENDYEAR_LABEL',true),"CONCAT(YEAR(`m`.`begin`),'-',IFNULL(YEAR(NULLIF(`m`.`end`,0)),''))"),
			"member_published" => array(JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_PUBLISHED_LABEL',true),'`m`.`published`'),
			"member_catid" => array(JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_CATID_LABEL',true),'`m`.`catid`'),
			"member_createdby" => array(JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_CREATEDBY_LABEL',true),'`m`.`createdby`'),
			"member_createddate" => array(JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_CREATEDDATE_LABEL',true),'`m`.`createddate`'),
			"member_modifiedby" => array(JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_MODIFIEDBY_LABEL',true),'`m`.`modifiedby`'),
			"member_modifieddate" => array(JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_MODIFIEDDATE_LABEL',true),'`m`.`modifieddate`'),
			"category_title" => array(JText::_('COM_CLUBMANAGEMENT_CATEGORIES_FIELD_TITLE_LABEL',true),'`c`.`title`'),
			"category_alias" => array(JText::_('COM_CLUBMANAGEMENT_CATEGORIES_FIELD_ALIAS_LABEL',true),'`c`.`alias`'),
			"category_path" => array(JText::_('COM_CLUBMANAGEMENT_CATEGORIES_FIELD_PATH_LABEL',true),'`c`.`path`')
		);
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since   1.6
	 */
	protected function populateState($ordering = null, $direction = null) {
		$app = JFactory::getApplication();
		$params = $app->getParams();
		$this->setState('params', $params);
		$this->setState('filter.published',1);
	}

	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return  string    An SQL query
	 * @since   1.6
	 */
	protected function getListQuery() {
		// Create a new query object.           
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		// Select some fields from the hello table
		$allFields = $this->getFields();
		$fields = array();
		foreach (array_keys($allFields) as $key) {
			if (isset($allFields[$key]) && !empty($allFields[$key])) {
				$field = $allFields[$key];
				array_push($fields,$field[1]." AS ".$key);
			}
		}
		$query->select($fields)
			->from($db->quoteName('#__nokCM_memberships','m'))
			->join('LEFT', $db->quoteName('#__nokCM_persons', 'p').' ON ('.$db->quoteName('m.person_id').'='.$db->quoteName('p.id').')')
			->join('LEFT', $db->quoteName('#__users', 'u').' ON ('.$db->quoteName('p.user_id').'='.$db->quoteName('u.id').')')
			->join('LEFT', $db->quoteName('#__categories', 'c').' ON ('.$db->quoteName('m.catid').'='.$db->quoteName('c.id').')');
		// Get configurations
		$this->paramsComponent = $this->state->get('params');
		$app = JFactory::getApplication();
		$currentMenu = $app->getMenu()->getActive();
		if (is_object( $currentMenu )) {
			$this->paramsMenuEntry = $currentMenu->params;
		} else {
			return $query;
		}
		// Filter by search in name.
		$where = array();
		$state = $this->paramsMenuEntry->get('memberstate');
		$membertype = $this->paramsMenuEntry->get('membertype');
		$publicity = $this->paramsMenuEntry->get('publicity');
		$catid = $this->paramsMenuEntry->get('catid');
		if ($state == "current") {
			array_push($where,"(".$db->quoteName('m.end')." IS NULL OR ".$db->quoteName('m.end')." = '0000-00-00')");
		}
		if ($state == "closed") {
			array_push($where,$db->quoteName('m.end')." IS NOT NULL");
			array_push($where,$db->quoteName('m.end')." <> '0000-00-00'");
		}
		if (is_array($membertype)) {
			array_push($where,$db->quoteName('m.type')." IN (".implode(", ",$db->quote($membertype)).")");
		} else {
			if (($membertype != "*") && ($membertype != "")) {
				array_push($where,$db->quoteName('m.type')." = ".$db->quote($membertype));
			}
		}
		if ($publicity == "published") {
			array_push($where,$db->quoteName('m.published')." = 1");
		}
		if ($publicity == "unpublished") {
			array_push($where,$db->quoteName('m.published')." = 0");
		}
		if ($catid != "0") {
			array_push($where,$db->quoteName('m.catid')." = ".$db->quote($catid));
		}
		if (count($where) > 0) {
			$query->where(implode(' AND ',$where));
		}
		// Add the list ordering clause.
		$sort = array();
		for ($i=1;$i<=4;$i++) {
			$fieldKeyCol = "sort_column_".$i;
			$fieldKeyDir = "sort_direction_".$i;
			$key = $this->paramsMenuEntry->get($fieldKeyCol);
			if (!empty($key)) {
				if (isset($allFields[$key]) && !empty($allFields[$key])) {
					$fieldname = $allFields[$key][1];
					array_push($sort, $fieldname.' '.$this->paramsMenuEntry->get($fieldKeyDir));
				}
			}
		}
		if (count($sort) > 0) {
			$query->order(implode(", ",$sort));
		}
		return $query;
        }

	public function getHeader($cols) {
		$fields = array();
		$allFields = $this->getFields();
		foreach ($cols as $col) {
			if (isset($allFields[$col])) {
				$field = $allFields[$col];
				array_push($fields,$field[0]);
			} else {
				array_push($fields,$col);
			}
		}
		return $fields;
	}

	public function translateFieldsToColumns($searchFields, $removePrefix=true) {
		$result = array();
		$allFields = $this->getFields();
		foreach($searchFields as $field) {
			if (isset($allFields[$field]) && !empty($allFields[$field])) {
				if ($removePrefix) {
					$resultField = str_replace('`p`.', '' , $allFields[$field][1]);
					$resultField = str_replace('`m`.', '' , $resultField);
					$resultField = str_replace('`b`.', '' , $resultField);
					$resultField = str_replace('`u`.', '' , $resultField);
					$resultField = str_replace('`c`.', '' , $resultField);
					$resultField = str_replace('`', '' , $resultField);
					array_push($result,$resultField);
				} else {
					array_push($result,$allFields[$field][1]);
				}
			}
		}
		return $result;
	}

}
?>
