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

class ClubManagementModelBoardentries extends JModelList
{
	public $_context = 'com_clubmanagement.boardentries';
	protected $_extension = 'com_clubmanagement';
	protected $paramsComponent;
	protected $paramsMenuEntry;
	private $_items = null;
	protected $fields = array (
			"board_id" => array('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_ID_LABEL','b.id'),
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
		// Get configurations
		$this->paramsComponent = $this->state->get('params');
		$app = JFactory::getApplication();
		$currentMenu = $app->getMenu()->getActive();
		if (is_object( $currentMenu )) {
			$this->paramsMenuEntry = $currentMenu->params;
		}

                // Create a new query object.           
                $db = JFactory::getDBO();
                $query = $db->getQuery(true);

                // Select some fields from the hello table
		$fields = array();
		foreach (array_keys($this->fields) as $key)
		{
			if ($this->fields[$key] && (!$this->distinct || ($key != "board_id"))) {
				$field = $this->fields[$key];
				array_push($fields,$field[1]." AS ".$key);
			}
		}

                $query->select($fields)
			->from($db->quoteName('#__nokCM_board','b'))
			->join('LEFT', $db->quoteName('#__nokCM_persons', 'p').' ON ('.$db->quoteName('b.person_id').'='.$db->quoteName('p.id').')')
			->join('LEFT', $db->quoteName('#__users', 'u').' ON ('.$db->quoteName('p.user_id').'='.$db->quoteName('u.id').')');

		// Filter by search in name.
		$where = array();
		$state = $this->paramsMenuEntry->get('boardstate');
		$job = $this->paramsMenuEntry->get('boardjob');
		$publicity = $this->paramsMenuEntry->get('publicity');
		if ($memberstate == "current") {
			array_push($where,$db->quoteName('b.end')." IS NULL");
		}
		if ($memberstate == "closed") {
			array_push($where,$db->quoteName('b.end')." IS NOT NULL");
		}
		if (($job != "*") && ($job != "")) {
			array_push($where,$db->quoteName('b.job')." = ".$db->quote($this->paramsMenuEntry->get('boardjob')));
		}
		if ($publicity == "published") {
			array_push($where,$db->quoteName('b.published')." = 1");
		}
		if ($publicity == "unpublished") {
			array_push($where,$db->quoteName('b.published')." = 1");
		}
		if (count($where) > 0)
		{
			$query->where(implode(' AND ',$where));
		}

		// Add the list ordering clause.
		$sort = array();
		for ($i=1;$i<=4;$i++) {
			$fieldKeyCol = "sort_column_".$i;
			$fieldKeyDir = "sort_direction_".$i;
			$key = $this->paramsMenuEntry->get($fieldKeyCol);
			if (!empty($key)) {
				if ($this->fields[$key]) {
					$fieldname = $this->fields[$key][1];
					array_push($sort, $db->quoteName($fieldname).' '.$this->paramsMenuEntry->get($fieldKeyDir));
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
		foreach ($cols as $col)
		{
			$field = $this->fields[$col];
			array_push($fields,$field[0]);
		}
		return $fields;
	}

}
?>
