<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Board
* @copyright	Copyright (c) 2014 Norbert Kümin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

defined('_JEXEC') or die;

jimport('joomla.application.component.helper');

class ClubManagementModelBoardentries extends JModelList
{
	public $_context = 'com_clubmanagement.boardentries';
	protected $_extension = 'com_clubmanagement';
	protected $paramsComponent;
	protected $paramsMenuEntry;
	private $_items = null;

	/**
	 * Constructor.
	 *
	 * @param   array  An optional associative array of configuration settings.
	 * @see     JController
	 * @since   1.6
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id', 'a.id',
				'name', 'a.name',
				'con_position', 'a.con_position',
				'suburb', 'a.suburb',
				'state', 'a.state',
				'country', 'a.country',
				'ordering', 'a.ordering',
				'sortname',
				'sortname1', 'a.sortname1',
				'sortname2', 'a.sortname2',
				'sortname3', 'a.sortname3'
			);
		}
		parent::__construct($config);
	}

	private function getFields() {
		$params = JComponentHelper::getParams('com_clubmanagement');
		return array (
			"board_id" => array(JText::_('COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_ID_LABEL',true),'`b`.`id`'),
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
	protected function populateState($ordering = null, $direction = null)
	{
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
        protected function getListQuery()
        {
                // Create a new query object.           
                $db = JFactory::getDBO();
                $query = $db->getQuery(true);

                // Select some fields from the hello table
		$allFields = $this->getFields();
		$fields = array();
		foreach (array_keys($allFields) as $key)
		{
			if ($allFields[$key] && (!$this->distinct || ($key != "board_id")))
			{
				$field = $allFields[$key];
				array_push($fields,$field[1]." AS ".$key);
			}
		}

                $query->select($fields)
			->from($db->quoteName('#__nokCM_board','b'))
			->join('LEFT', $db->quoteName('#__nokCM_persons', 'p').' ON ('.$db->quoteName('b.person_id').'='.$db->quoteName('p.id').')')
			->join('LEFT', $db->quoteName('#__users', 'u').' ON ('.$db->quoteName('p.user_id').'='.$db->quoteName('u.id').')');

		// Get configurations
		$this->paramsComponent = $this->state->get('params');
		$app = JFactory::getApplication();
		$currentMenu = $app->getMenu()->getActive();
		if (is_object($currentMenu))
		{
			$this->paramsMenuEntry = $currentMenu->params;
		} else {
			return $query;
		}

		// Filter by search in name.
		$where = array();
		$state = $this->paramsMenuEntry->get('boardstate');
		$job = $this->paramsMenuEntry->get('boardjob');
		$publicity = $this->paramsMenuEntry->get('publicity');
		if ($state == "current")
		{
			array_push($where,"(".$db->quoteName('b.end')." IS NULL OR ".$db->quoteName('b.end')." = '0000-00-00')");
		}
		if ($state == "closed")
		{
			array_push($where,$db->quoteName('b.end')." IS NOT NULL");
			array_push($where,$db->quoteName('b.end')." <> '0000-00-00'");
		}
		if (($job != "*") && ($job != ""))
		{
			array_push($where,$db->quoteName('b.job')." = ".$db->quote($this->paramsMenuEntry->get('boardjob')));
		}
		if ($publicity == "published")
		{
			array_push($where,$db->quoteName('b.published')." = 1");
		}
		if ($publicity == "unpublished")
		{
			array_push($where,$db->quoteName('b.published')." = 0");
		}
		if (count($where) > 0)
		{
			$query->where(implode(' AND ',$where));
		}

		// Add the list ordering clause.
		$sort = array();
		for ($i=1;$i<=4;$i++)
		{
			$fieldKeyCol = "sort_column_".$i;
			$fieldKeyDir = "sort_direction_".$i;
			$key = $this->paramsMenuEntry->get($fieldKeyCol);
			if (!empty($key)) {
				if ($allFields[$key])
				{
					$fieldname = $allFields[$key][1];
					array_push($sort, $fieldname.' '.$this->paramsMenuEntry->get($fieldKeyDir));
				}
			}
		}
		if (count($sort) > 0)
		{
			$query->order(implode(", ",$sort));
		}
                return $query;
        }

        public function getHeader($cols)
        {
		$fields = array();
		$allFields = $this->getFields();
		foreach ($cols as $col)
		{
			$field = $allFields[$col];
			array_push($fields,$field[0]);
		}
		return $fields;
	}

	public function translateFieldsToColumns($searchFields, $removePrefix=true)
	{
		$result = array();
		$allFields = $this->getFields();
		foreach($searchFields as $field)
		{
			if ($allFields[$field])
			{
				if ($removePrefix)
				{
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
}
?>
