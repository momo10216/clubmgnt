<?php
/**
* @version		0.95
* @package		Joomla
* @subpackage	ClubManagement-Person
* @copyright	Copyright (c) 2009 Norbert Kümin. All rights reserved.
* @license		http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author		Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

// Define object b ased on the table object
require_once( dirname(__FILE__).DS.'nokTable.class.php');

class nokCMPerson extends nokTable {

	function nokCMPerson($component) {
		$this->nokTable('#__nokCM_persons','person');

		// Table columns
		$this->addTableColumn("id", "int(11) unsigned", "N", "", "auto_increment");
		$this->addTableColumn("salutation", "varchar(25)", "Y", "", "");
		$this->addTableColumn("firstname", "varchar(50) BINARY", "Y", "", "");
		$this->addTableColumn("middlename", "varchar(50) BINARY", "Y", "", "");
		$this->addTableColumn("name", "varchar(50) BINARY", "N", "", "");
		$this->addTableColumn("nickname", "varchar(50) BINARY", "Y", "", "");
		$this->addTableColumn("birthday", "date", "Y", "", "");
		$this->addTableColumn("address", "varchar(100) BINARY", "Y", "", "");
		$this->addTableColumn("city", "varchar(50) BINARY", "N", "", "");
		$this->addTableColumn("zip", "varchar(10) BINARY", "Y", "", "");
		$this->addTableColumn("country", "varchar(100) BINARY", "N", "", "");
		$this->addTableColumn("state", "varchar(100) BINARY", "Y", "", "");
		$this->addTableColumn("telephone", "varchar(25)", "Y", "", "");
		$this->addTableColumn("mobile", "varchar(25)", "Y", "", "");
		$this->addTableColumn("url", "varchar(250)", "Y", "", "");
		$this->addTableColumn("email", "varchar(100)", "Y", "", "");
		$this->addTableColumn("user_id", "int(11)", "Y", "", "");
		$this->addTableColumn("description", "text", "Y", "", "");
		$this->addTableColumn("image", "varchar(250)", "Y", "", "");
		$this->addTableColumn("createdby", "varchar(50)", "Y", "", "");
		$this->addTableColumn("createddate", "datetime", "Y", "", "");
		$this->addTableColumn("modifiedby", "varchar(50)", "Y", "", "");
		$this->addTableColumn("modifieddate", "datetime", "Y", "", "");
		$this->addTableColumn("custom1", "varchar(255)", "Y", "", "");
		$this->addTableColumn("custom2", "varchar(255)", "Y", "", "");
		$this->addTableColumn("custom3", "varchar(255)", "Y", "", "");
		$this->addTableColumn("custom4", "varchar(255)", "Y", "", "");
		$this->addTableColumn("custom5", "varchar(255)", "Y", "", "");
		$this->addTableColumn("birthname", "varchar(50)", "Y", "", "");
		$this->addTableColumn("deceased", "date", "Y", "", "");
		$this->addTableColumn("hh_person_id", "int(11) unsigned", "Y", "", "");
		$this->addTableColumn("hh_salutation_override", "varchar(50)", "Y", "", "");
		$this->addTableColumn("hh_name_override", "varchar(255)", "Y", "", "");
		$this->addTableIndex("hh_person_id", "hh_person_id", "N");
		$this->addTableIndex("user_id", "user_id", "N");

		$params = &JComponentHelper::getParams( 'com_clubmanagement' );
		$picdir = $params->get( 'image_dir' );

		// Settings
		$this->addSetting("Primary_Key","id");
		$this->addSetting("Command_Parameter","task");
		$this->addSetting("Command_Show","show");
		$this->addSetting("Command_New","add");
		$this->addSetting("Command_Modify","edit");
		$this->addSetting("Command_Delete","remove");
		$this->addSetting("Command_List","list");
		$this->addSetting("Command_Save","save");
		$this->addSetting("Command_Export","export");
		$this->addSetting("PrimaryKey_Parameter","cid[]");
		$this->addSetting("Object_Parameter","cmobj");

		// Define representation of the fields
		$this->addColumnRepresentation("id", "readonly");
		$this->addColumnRepresentation("salutation", "text", 20, 20);
		$this->addColumnRepresentation("name", "text", 50, 50);
		$this->addColumnRepresentation("birthname", "text", 50, 50);
		$this->addColumnRepresentation("firstname", "text", 50, 50);
		$this->addColumnRepresentation("middlename", "text", 50, 50);
		$this->addColumnRepresentation("nickname", "text", 50, 50);
		$this->addColumnRepresentation("nickfirstname:IFNULL(`nickname`,`firstname`)", "readonly", "text");
		$this->addColumnRepresentation("address", "text", 50, 100);
		$this->addColumnRepresentation("zip", "text", 50, 50);
		$this->addColumnRepresentation("city", "text", 50, 50);
		$this->addColumnRepresentation("state", "text", 50, 100);
		$this->addColumnRepresentation("country", "text", 50, 100);
		$this->addColumnRepresentation("hh_person_id", "selection", "id", "CONCAT(IFNULL(`name`,''),' ',IFNULL(`firstname`,''),',',',',IFNULL(`address`,''),',',IFNULL(`city`,''))", "#__nokCM_persons", "`hh_person_id` IS NULL", "`name`,`firstname`,`city`"," ");
		$this->addColumnRepresentation("hh_salutation_override", "text", 50, 50);
		$this->addColumnRepresentation("hh_name_override", "text", 50, 255);
		$this->addColumnRepresentation("hh_name:name:#__nokCM_persons:#__nokCM_persons.hh_person_id=hh.id:hh", "readonly", "text");
		$this->addColumnRepresentation("hh_firstname:firstname:#__nokCM_persons:#__nokCM_persons.hh_person_id=hh.id:hh", "readonly", "text");
		$this->addColumnRepresentation("hh_address:address:#__nokCM_persons:#__nokCM_persons.hh_person_id=hh.id:hh", "readonly", "text");
		$this->addColumnRepresentation("hh_city:city:#__nokCM_persons:#__nokCM_persons.hh_person_id=hh.id:hh", "readonly", "text");
		$this->addColumnRepresentation("hh_birthday:birthday:#__nokCM_persons:#__nokCM_persons.hh_person_id=hh.id:hh", "readonly", "text");
		$this->addColumnRepresentation("birthday", "date");
		$this->addColumnRepresentation("abirthday:IF(DATE_ADD(#__nokCM_persons.`birthday`, INTERVAL (YEAR(NOW()) - YEAR(#__nokCM_persons.`birthday`)) YEAR) < CURDATE(),DATE_ADD(#__nokCM_persons.`birthday`, INTERVAL (YEAR(NOW()) - YEAR(#__nokCM_persons.`birthday`) + 1) YEAR),DATE_ADD(#__nokCM_persons.`birthday`, INTERVAL (YEAR(NOW()) - YEAR(#__nokCM_persons.`birthday`)) YEAR))", "readonly", "text");
		$this->addColumnRepresentation("deceased", "date");
		$this->addColumnRepresentation("telephone", "text", 25, 25);
		$this->addColumnRepresentation("mobile", "text", 25, 25);
		$this->addColumnRepresentation("email", "email", 50, 100);
		$this->addColumnRepresentation("url", "url", 50, 250);
		$this->addColumnRepresentation("user_id", "selection", "id", "username", "#__users", "", "username", JText::_( 'SELECTION_NONE'));
		if ((strtolower($picdir) != "none") && ($picdir != "")) {
			$this->addColumnRepresentation("image", "image", $picdir);
		}
		$this->addColumnRepresentation("custom1", "text", 50, 255);
		$this->addColumnRepresentation("custom2", "text", 50, 255);
		$this->addColumnRepresentation("custom3", "text", 50, 255);
		$this->addColumnRepresentation("custom4", "text", 50, 255);
		$this->addColumnRepresentation("custom5", "text", 50, 255);
		$this->addColumnRepresentation("description", "text", 50, 0, 10);
		$this->addColumnRepresentation("createdby", "readonly", "text", "CurrentUser");
		$this->addColumnRepresentation("createddate", "readonly", "datetime", "CurrentDate");
		$this->addColumnRepresentation("modifiedby", "readonly", "text", "CurrentUser");
		$this->addColumnRepresentation("modifieddate", "readonly", "datetime", "CurrentDate");

		//Auto set columns
		$this->addColumnAutoSet("createdby");
		$this->addColumnAutoSet("createddate");
		$this->addColumnAutoSet("modifiedby");
		$this->addColumnAutoSet("modifieddate");

		//No updatebel columns
		$this->addColumnNoUpdate("id");
		$this->addColumnNoUpdate("createdby");
		$this->addColumnNoUpdate("createddate");
		
		// Define mandatory fields
		$this->addColumnMandatory("name");
		$this->addColumnMandatory("city");
		$this->addColumnMandatory("country");

		// Define fields and columnname for the list
		$this->addColumnDisplay("list", "name", JText::_( 'TABLE_NOKCM_PERSONS.NAME'));
		$this->addColumnDisplay("list", "firstname", JText::_( 'TABLE_NOKCM_PERSONS.FIRSTNAME'));
		$this->addColumnDisplay("list", "address", JText::_( 'TABLE_NOKCM_PERSONS.ADDRESS'));
		$this->addColumnDisplay("list", "zip", JText::_( 'TABLE_NOKCM_PERSONS.ZIP'));
		$this->addColumnDisplay("list", "city", JText::_( 'TABLE_NOKCM_PERSONS.CITY'));
		$this->setDefaultOrder("list", "name, firstname, city");
		$this->addListFilter("filter_all", "text", "name;firstname;address;zip;city", array());

		// Define fields and lables for the detail view
		$this->addColumnDisplay("show", "salutation", JText::_( 'TABLE_NOKCM_PERSONS.SALUTATION'));
		$this->addColumnDisplay("show", "name", JText::_( 'TABLE_NOKCM_PERSONS.NAME'));
		$this->addColumnDisplay("show", "birthname", JText::_( 'TABLE_NOKCM_PERSONS.BIRTHNAME'));
		$this->addColumnDisplay("show", "firstname", JText::_( 'TABLE_NOKCM_PERSONS.FIRSTNAME'));
		$this->addColumnDisplay("show", "middlename", JText::_( 'TABLE_NOKCM_PERSONS.MIDDLENAME'));
		$this->addColumnDisplay("show", "nickname", JText::_( 'TABLE_NOKCM_PERSONS.NICKNAME'));
		$this->addColumnDisplay("show", "address", JText::_( 'TABLE_NOKCM_PERSONS.ADDRESS'));
		$this->addColumnDisplay("show", "zip", JText::_( 'TABLE_NOKCM_PERSONS.ZIP'));
		$this->addColumnDisplay("show", "city", JText::_( 'TABLE_NOKCM_PERSONS.CITY'));
		$this->addColumnDisplay("show", "state", JText::_( 'TABLE_NOKCM_PERSONS.STATE'));
		$this->addColumnDisplay("show", "country", JText::_( 'TABLE_NOKCM_PERSONS.COUNTRY'));
		$this->addColumnDisplay("show", "hh_person_id", JText::_( 'TABLE_NOKCM_PERSONS.HH_PERSON_ID'));
		$this->addColumnDisplay("show", "hh_salutation_override", JText::_( 'TABLE_NOKCM_PERSONS.HH_SALUTATION_OVERRIDE'));
		$this->addColumnDisplay("show", "hh_name_override", JText::_( 'TABLE_NOKCM_PERSONS.HH_NAME_OVERRIDE'));
		$this->addColumnDisplay("show", "birthday", JText::_( 'TABLE_NOKCM_PERSONS.BIRTHDAY'));
		$this->addColumnDisplay("show", "deceased", JText::_( 'TABLE_NOKCM_PERSONS.DECEASED'));
		$this->addColumnDisplay("show", "telephone", JText::_( 'TABLE_NOKCM_PERSONS.TELEPHONE'));
		$this->addColumnDisplay("show", "mobile", JText::_( 'TABLE_NOKCM_PERSONS.MOBILE'));
		$this->addColumnDisplay("show", "email", JText::_( 'TABLE_NOKCM_PERSONS.EMAIL'));
		$this->addColumnDisplay("show", "url", JText::_( 'TABLE_NOKCM_PERSONS.URL'));
		$this->addColumnDisplay("show", "user_id", JText::_( 'TABLE_NOKCM_PERSONS.USER_ID'));
		if ((strtolower($picdir) != "none") && ($picdir != "")) {
			$this->addColumnDisplay("show", "image", JText::_( 'TABLE_NOKCM_PERSONS.IMAGE'));
		}
		$this->addColumnDisplay("show", "custom1", JText::_( $params->get( 'custom1' )));
		$this->addColumnDisplay("show", "custom2", JText::_( $params->get( 'custom2' )));
		$this->addColumnDisplay("show", "custom3", JText::_( $params->get( 'custom3' )));
		$this->addColumnDisplay("show", "custom4", JText::_( $params->get( 'custom4' )));
		$this->addColumnDisplay("show", "custom5", JText::_( $params->get( 'custom5' )));
		$this->addColumnDisplay("show", "description", JText::_( 'TABLE_NOKCM_PERSONS.DESCRIPTION'));
		$this->addColumnDisplay("show", "createdby", JText::_( 'TABLE_NOKCM_PERSONS.CREATEDBY'));
		$this->addColumnDisplay("show", "createddate", JText::_( 'TABLE_NOKCM_PERSONS.CREATEDDATE'));
		$this->addColumnDisplay("show", "modifiedby", JText::_( 'TABLE_NOKCM_PERSONS.MODIFIEDBY'));
		$this->addColumnDisplay("show", "modifieddate", JText::_( 'TABLE_NOKCM_PERSONS.MODIFIEDDATE'));

		// Define fields and lables for data entry
		$this->addColumnDisplay("edit", "salutation", JText::_( 'TABLE_NOKCM_PERSONS.SALUTATION'));
		$this->addColumnDisplay("edit", "name", JText::_( 'TABLE_NOKCM_PERSONS.NAME'));
		$this->addColumnDisplay("edit", "birthname", JText::_( 'TABLE_NOKCM_PERSONS.BIRTHNAME'));
		$this->addColumnDisplay("edit", "firstname", JText::_( 'TABLE_NOKCM_PERSONS.FIRSTNAME'));
		$this->addColumnDisplay("edit", "middlename", JText::_( 'TABLE_NOKCM_PERSONS.MIDDLENAME'));
		$this->addColumnDisplay("edit", "nickname", JText::_( 'TABLE_NOKCM_PERSONS.NICKNAME'));
		$this->addColumnDisplay("edit", "address", JText::_( 'TABLE_NOKCM_PERSONS.ADDRESS'));
		$this->addColumnDisplay("edit", "zip", JText::_( 'TABLE_NOKCM_PERSONS.ZIP'));
		$this->addColumnDisplay("edit", "city", JText::_( 'TABLE_NOKCM_PERSONS.CITY'));
		$this->addColumnDisplay("edit", "state", JText::_( 'TABLE_NOKCM_PERSONS.STATE'));
		$this->addColumnDisplay("edit", "country", JText::_( 'TABLE_NOKCM_PERSONS.COUNTRY'));
		$this->addColumnDisplay("edit", "hh_person_id", JText::_( 'TABLE_NOKCM_PERSONS.HH_PERSON_ID'));
		$this->addColumnDisplay("edit", "hh_salutation_override", JText::_( 'TABLE_NOKCM_PERSONS.HH_SALUTATION_OVERRIDE'));
		$this->addColumnDisplay("edit", "hh_name_override", JText::_( 'TABLE_NOKCM_PERSONS.HH_NAME_OVERRIDE'));
		$this->addColumnDisplay("edit", "birthday", JText::_( 'TABLE_NOKCM_PERSONS.BIRTHDAY'));
		$this->addColumnDisplay("edit", "deceased", JText::_( 'TABLE_NOKCM_PERSONS.DECEASED'));
		$this->addColumnDisplay("edit", "telephone", JText::_( 'TABLE_NOKCM_PERSONS.TELEPHONE'));
		$this->addColumnDisplay("edit", "mobile", JText::_( 'TABLE_NOKCM_PERSONS.MOBILE'));
		$this->addColumnDisplay("edit", "email", JText::_( 'TABLE_NOKCM_PERSONS.EMAIL'));
		$this->addColumnDisplay("edit", "url", JText::_( 'TABLE_NOKCM_PERSONS.URL'));
		$this->addColumnDisplay("edit", "user_id", JText::_( 'TABLE_NOKCM_PERSONS.USER_ID'));
		if ((strtolower($picdir) != "none") && ($picdir != "")) {
			$this->addColumnDisplay("edit", "image", JText::_( 'TABLE_NOKCM_PERSONS.IMAGE'));
		}
		$this->addColumnDisplay("edit", "custom1", JText::_( $params->get( 'custom1' )));
		$this->addColumnDisplay("edit", "custom2", JText::_( $params->get( 'custom2' )));
		$this->addColumnDisplay("edit", "custom3", JText::_( $params->get( 'custom3' )));
		$this->addColumnDisplay("edit", "custom4", JText::_( $params->get( 'custom4' )));
		$this->addColumnDisplay("edit", "custom5", JText::_( $params->get( 'custom5' )));
		$this->addColumnDisplay("edit", "description", JText::_( 'TABLE_NOKCM_PERSONS.DESCRIPTION'));
		$this->addColumnDisplay("edit", "createdby", JText::_( 'TABLE_NOKCM_PERSONS.CREATEDBY'));
		$this->addColumnDisplay("edit", "createddate", JText::_( 'TABLE_NOKCM_PERSONS.CREATEDDATE'));
		$this->addColumnDisplay("edit", "modifiedby", JText::_( 'TABLE_NOKCM_PERSONS.MODIFIEDBY'));
		$this->addColumnDisplay("edit", "modifieddate", JText::_( 'TABLE_NOKCM_PERSONS.MODIFIEDDATE'));

		// Define fields and lables for view
		$this->addColumnDisplay("view", "salutation", JText::_( 'TABLE_NOKCM_PERSONS.SALUTATION'));
		$this->addColumnDisplay("view", "name", JText::_( 'TABLE_NOKCM_PERSONS.NAME'));
		$this->addColumnDisplay("view", "birthname", JText::_( 'TABLE_NOKCM_PERSONS.BIRTHNAME'));
		$this->addColumnDisplay("view", "firstname", JText::_( 'TABLE_NOKCM_PERSONS.FIRSTNAME'));
		$this->addColumnDisplay("view", "middlename", JText::_( 'TABLE_NOKCM_PERSONS.MIDDLENAME'));
		$this->addColumnDisplay("view", "nickname", JText::_( 'TABLE_NOKCM_PERSONS.NICKNAME'));
		$this->addColumnDisplay("view", "nickfirstname", JText::_( 'TABLE_NOKCM_PERSONS.NICKFIRSTNAME'));
		$this->addColumnDisplay("view", "address", JText::_( 'TABLE_NOKCM_PERSONS.ADDRESS'));
		$this->addColumnDisplay("view", "zip", JText::_( 'TABLE_NOKCM_PERSONS.ZIP'));
		$this->addColumnDisplay("view", "city", JText::_( 'TABLE_NOKCM_PERSONS.CITY'));
		$this->addColumnDisplay("view", "state", JText::_( 'TABLE_NOKCM_PERSONS.STATE'));
		$this->addColumnDisplay("view", "country", JText::_( 'TABLE_NOKCM_PERSONS.COUNTRY'));
		$this->addColumnDisplay("view", "birthday", JText::_( 'TABLE_NOKCM_PERSONS.BIRTHDAY'));
		$this->addColumnDisplay("view", "abirthday", JText::_( 'TABLE_NOKCM_PERSONS.ABIRTHDAY'));
		$this->addColumnDisplay("view", "deceased", JText::_( 'TABLE_NOKCM_PERSONS.DECEASED'));
		$this->addColumnDisplay("view", "telephone", JText::_( 'TABLE_NOKCM_PERSONS.TELEPHONE'));
		$this->addColumnDisplay("view", "mobile", JText::_( 'TABLE_NOKCM_PERSONS.MOBILE'));
		$this->addColumnDisplay("view", "email", JText::_( 'TABLE_NOKCM_PERSONS.EMAIL'));
		$this->addColumnDisplay("view", "url", JText::_( 'TABLE_NOKCM_PERSONS.URL'));
		$this->addColumnDisplay("view", "user_id", JText::_( 'TABLE_NOKCM_PERSONS.USER_ID'));
		if ((strtolower($picdir) != "none") && ($picdir != "")) {
			$this->addColumnDisplay("view", "image", JText::_( 'TABLE_NOKCM_PERSONS.IMAGE'));
		}
		$this->addColumnDisplay("view", "custom1", JText::_( $params->get( 'custom1' )));
		$this->addColumnDisplay("view", "custom2", JText::_( $params->get( 'custom2' )));
		$this->addColumnDisplay("view", "custom3", JText::_( $params->get( 'custom3' )));
		$this->addColumnDisplay("view", "custom4", JText::_( $params->get( 'custom4' )));
		$this->addColumnDisplay("view", "custom5", JText::_( $params->get( 'custom5' )));
		$this->addColumnDisplay("view", "description", JText::_( 'TABLE_NOKCM_PERSONS.DESCRIPTION'));
		$this->addColumnDisplay("view", "createdby", JText::_( 'TABLE_NOKCM_PERSONS.CREATEDBY'));
		$this->addColumnDisplay("view", "createddate", JText::_( 'TABLE_NOKCM_PERSONS.CREATEDDATE'));
		$this->addColumnDisplay("view", "modifiedby", JText::_( 'TABLE_NOKCM_PERSONS.MODIFIEDBY'));
		$this->addColumnDisplay("view", "modifieddate", JText::_( 'TABLE_NOKCM_PERSONS.MODIFIEDDATE'));

		// Define fields for export
		$this->addExportColumn("salutation","Y");
		$this->addExportColumn("name","Y");
		$this->addExportColumn("birthname","Y");
		$this->addExportColumn("firstname","Y");
		$this->addExportColumn("middlename","Y");
		$this->addExportColumn("nickname","Y");
		$this->addExportColumn("address","Y");
		$this->addExportColumn("zip","Y");
		$this->addExportColumn("city","Y");
		$this->addExportColumn("state","Y");
		$this->addExportColumn("country","Y");
		$this->addExportColumn("hh_salutation_override","Y");
		$this->addExportColumn("hh_name_override","Y");
		$this->addExportColumn("hh_name","N");
		$this->addExportColumn("hh_firstname","N");
		$this->addExportColumn("hh_address","N");
		$this->addExportColumn("hh_city","N");
		$this->addExportColumn("hh_birthday","N");
		$this->addExportColumn("birthday","Y");
		$this->addExportColumn("deceased","Y");
		$this->addExportColumn("telephone","Y");
		$this->addExportColumn("mobile","Y");
		$this->addExportColumn("email","Y");
		$this->addExportColumn("url","Y");
		if ((strtolower($picdir) != "none") && ($picdir != "")) {
			$this->addExportColumn("image","Y");
		}
		$this->addExportColumn("custom1","Y");
		$this->addExportColumn("custom2","Y");
		$this->addExportColumn("custom3","Y");
		$this->addExportColumn("custom4","Y");
		$this->addExportColumn("custom5","Y");
		$this->addExportColumn("description","Y");
		$this->setExportSortOrder("`hh_person_id`");
		$this->setImportForeignKey("hh_name:hh_firstname:hh_address:hh_city:hh_birthday", "hh_person_id", "#__nokCM_persons", "name:firstname:address:city:birthday", "id");
		$this->setImportPrimaryKey("name:firstname:address:city:birthday");

		// Define toolbar itemms
		//$this->addToolbarEntry("publish");

		//$this->addToolbarEntry("unpublish");
		$this->addToolbarEntry("add");
		$this->addToolbarEntry("edit");
		$this->addToolbarEntry("delete");
		$this->addToolbarEntry("export");
		$this->addToolbarEntry("import");
		$this->addToolbarEntry("preferences");
		$this->addToolbarEntry("help");

		//Data consitency definition
		$this->addDeleteRule("check", "id", "#__nokCM_memberships", "person_id");
		$this->addDeleteRule("check", "id", "#__nokCM_board", "person_id");
		$this->addDeleteRule("remove_ref", "id", "#__nokCM_persons", "hh_person_id");
	}

	function menu ( $cmd, $option )
	{
		switch ($cmd)
		{
			case 'select':
				$this->select_record();
				break;
			default:
				parent::menu( $cmd, $option );
				break;
		}
	}

	function user_record_ids($id = "")
	{
		$user =& JFactory::getUser();
		$strSQL = "SELECT `".$this->getSetting("Primary_Key")."` FROM `".$this->table."` ";
		$strSQL .= "WHERE user_id='".$user->id."'";
		if ($id != "") $strSQL .= " AND id='".addslashes($id)."'";
		$this->db->setQuery( $strSQL );
		$rows = $this->db->loadRowList();
		return $rows;
	}

	function select_record()
	{
		global $mainframe;

		$uri = JFactory::getURI();
		$option = $uri->getVar('option');
		$user =& JFactory::getUser();
		$limit = $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );

		// Page-Navigation: Get the total number of records
		$strSQL = "SELECT COUNT(*) FROM `".$this->table."`";
		$this->db->setQuery( $strSQL );
		$total = $this->db->loadResult();
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );

		// Order
		$filter_order = $mainframe->getUserStateFromRequest( "$option.filter_order", 'filter_order', '', 'cmd' );
		$filter_order_Dir = $mainframe->getUserStateFromRequest( "$option.filter_order_Dir", 'filter_order_Dir', '', 'word' );
		if ($filter_order != "")
		{
			$order = $filter_order .' '. $filter_order_Dir;
		}
		if ($order == "")
		{
			$order = $this->default_order["list"];
		}

		//Query
		$strSQL = $this->_calcquery($this->column_list, $where, $order, $this->getSetting("Primary_Key"));
		$strSQL = $strSQL . " LIMIT ".$pageNav->limitstart." , ".$pageNav->limit;
		$this->db->setQuery( $strSQL );
		$rows = $this->db->loadRowList();
		
		//Header
		JHTML::_('behavior.tooltip');
		echo "<form action=\"index.php?option=" . $option . "\" method=\"post\" name=\"adminForm\">\n";
		echo "<table class=\"adminlist\">\n";
		echo "<thead><tr>";
		reset($this->column_list);
		while (list($strColumn,$strTitle) = each($this->column_list))
		{
			echo "<th>";
			echo JHTML::_('grid.sort', $strTitle, $strColumn, $filter_order_Dir, $filter_order);
			echo "</th>";
		}
		
		echo "</tr></thead>\n";
		echo "<tfoot><tr><td colspan=\"" . (count($this->column_list)) . "\">";
		echo $pageNav->getListFooter();
		echo "</td>";
		echo "</tr>";
		echo "</tfoot>\n";
		
		//List
		echo "<tbody>";
		$n = count( $rows );
		for ($i = 0; $i < $n; $i++)
		{
			$row = $rows[$i];
			$id = array_shift($row);
			$name = implode($row, " ");
			echo "<tr class=\"row". ($i % 2). "\">";
			reset($this->column_list);
			$rp=0;
			while (list($strColumn,$strTitle) = each($this->column_list))
			{
				$field = $row[$rp];
				echo "<td>";
				if ($rp == 0)
				{
					echo "<a style=\"cursor: pointer;\" onclick=\"window.parent.jSelectRecord('".$id."', '".$name."', 'id');\">";
					echo $this->_displayField($strColumn,$field,$i);
					echo "</a>";
				}
				else
				{
					echo $this->_displayField($strColumn,$field,$i);
				}
				echo "</td>";
				$rp++;
			}
			echo "<td>";
			echo "</tr>\n";
		}
		echo "</tbody></table>\n";
		echo "<input type=\"hidden\" name=\"boxchecked\" value=\"0\" />\n";
		echo "<input type=\"hidden\" name=\"filter_order\" value=\"" . $lists['order'] . "\" />\n";
		echo "<input type=\"hidden\" name=\"filter_order_Dir\" value=\"" . $lists['order_Dir'] . "\" />\n";
		echo JHTML::_( 'form.token' );
		echo "</form>\n";
	}
}
?>
