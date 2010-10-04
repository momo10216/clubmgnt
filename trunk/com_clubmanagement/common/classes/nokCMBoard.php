<?php
/**
* @version		0.95
* @package		Joomla
* @subpackage	ClubManagement-Board
* @copyright	Copyright (c) 2009 Norbert Kümin. All rights reserved.
* @license		http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author		Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

// Define object b ased on the table object
require_once( dirname(__FILE__).DS.'nokTable.class.php');

class nokCMBoard extends nokTable {

	function nokCMBoard($component) {
		$this->nokTable('#__nokCM_board','board');

		// Table columns
		$this->addTableColumn("id", "int(11) unsigned", "N", "", "auto_increment");
		$this->addTableColumn("person_id", "int(11) unsigned", "N", "0", "");
		$this->addTableColumn("job", "varchar(25)", "N", "", "");
		$this->addTableColumn("begin", "date", "N", "", "");
		$this->addTableColumn("end", "date", "Y", "", "");
		$this->addTableColumn("published", "int(1)", "N", "0", "");
		$this->addTableColumn("sortorder", "varchar(16)", "Y", "", "");
		$this->addTableColumn("createdby", "varchar(50)", "Y", "", "");
		$this->addTableColumn("createddate", "datetime", "Y", "", "");
		$this->addTableColumn("modifiedby", "varchar(50)", "Y", "", "");
		$this->addTableColumn("modifieddate", "datetime", "Y", "", "");

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
		$this->addColumnRepresentation("published", "publish");
		$this->addColumnRepresentation("person_id", "selection", "id", "CONCAT(IFNULL(`name`,''),' ',IFNULL(`firstname`,''),',',',',IFNULL(`address`,''),',',IFNULL(`city`,''))", "#__nokCM_persons", "", "`name`,`firstname`,`city`");
		$this->addColumnRepresentation("job", "textselect", $params->get( 'board_jobs' ));
		$this->addColumnRepresentation("sortorder", "text");
		$this->addColumnRepresentation("begin", "date");
		$this->addColumnRepresentation("end", "date");
		$this->addColumnRepresentation("beginyear:YEAR(#__nokCM_board.`begin`)", "readonly", "text");
		$this->addColumnRepresentation("endyear:YEAR(#__nokCM_board.`end`)", "readonly", "text");
		$this->addColumnRepresentation("beginendyear:CONCAT(YEAR(#__nokCM_board.`begin`),'-',IFNULL(YEAR(#__nokCM_board.`end`),''))", "readonly", "text");
		$this->addColumnRepresentation("createdby", "readonly", "text", "CurrentUser");
		$this->addColumnRepresentation("createddate", "readonly", "datetime", "CurrentDate");
		$this->addColumnRepresentation("modifiedby", "readonly", "text", "CurrentUser");
		$this->addColumnRepresentation("modifieddate", "readonly", "datetime", "CurrentDate");
		$this->addColumnRepresentation("salutation:salutation:#__nokCM_persons:#__nokCM_board.person_id=#__nokCM_persons.id", "readonly", "text");
		$this->addColumnRepresentation("name:name:#__nokCM_persons:#__nokCM_board.person_id=#__nokCM_persons.id", "readonly", "text");
		$this->addColumnRepresentation("birthname:birthname:#__nokCM_persons:#__nokCM_board.person_id=#__nokCM_persons.id", "readonly", "text");
		$this->addColumnRepresentation("firstname:firstname:#__nokCM_persons:#__nokCM_board.person_id=#__nokCM_persons.id", "readonly", "text");
		$this->addColumnRepresentation("middlename:middlename:#__nokCM_persons:#__nokCM_board.person_id=#__nokCM_persons.id", "readonly", "text");
		$this->addColumnRepresentation("nickname:nickname:#__nokCM_persons:#__nokCM_board.person_id=#__nokCM_persons.id", "readonly", "text");
		$this->addColumnRepresentation("nickfirstname:IFNULL(#__nokCM_persons.`nickname`,#__nokCM_persons.`firstname`):#__nokCM_persons:#__nokCM_board.person_id=#__nokCM_persons.id", "readonly", "text");
		$this->addColumnRepresentation("address:address:#__nokCM_persons:#__nokCM_board.person_id=#__nokCM_persons.id", "readonly", "text");
		$this->addColumnRepresentation("city:city:#__nokCM_persons:#__nokCM_board.person_id=#__nokCM_persons.id", "readonly", "text");
		$this->addColumnRepresentation("zip:zip:#__nokCM_persons:#__nokCM_board.person_id=#__nokCM_persons.id", "readonly", "text");
		$this->addColumnRepresentation("country:country:#__nokCM_persons:#__nokCM_board.person_id=#__nokCM_persons.id", "readonly", "text");
		$this->addColumnRepresentation("state:state:#__nokCM_persons:#__nokCM_board.person_id=#__nokCM_persons.id", "readonly", "text");
		$this->addColumnRepresentation("hh_person_id:hh_person_id:#__nokCM_persons:#__nokCM_board.person_id=#__nokCM_persons.id", "readonly", "text");
		$this->addColumnRepresentation("hh_salutation_override:hh_salutation_override:#__nokCM_persons:#__nokCM_board.person_id=#__nokCM_persons.id", "readonly", "text");
		$this->addColumnRepresentation("hh_name_override:hh_name_override:#__nokCM_persons:#__nokCM_board.person_id=#__nokCM_persons.id", "readonly", "text");
		$this->addColumnRepresentation("birthday:birthday:#__nokCM_persons:#__nokCM_board.person_id=#__nokCM_persons.id", "readonly", "text");
		$this->addColumnRepresentation("abirthday:IF(DATE_ADD(#__nokCM_persons.`birthday`, INTERVAL (YEAR(NOW()) - YEAR(#__nokCM_persons.`birthday`)) YEAR) < CURDATE(),DATE_ADD(#__nokCM_persons.`birthday`, INTERVAL (YEAR(NOW()) - YEAR(#__nokCM_persons.`birthday`) + 1) YEAR),DATE_ADD(#__nokCM_persons.`birthday`, INTERVAL (YEAR(NOW()) - YEAR(#__nokCM_persons.`birthday`)) YEAR)):#__nokCM_persons:#__nokCM_board.person_id=#__nokCM_persons.id", "readonly", "date");
		$this->addColumnRepresentation("deceased:deceased:#__nokCM_persons:#__nokCM_board.person_id=#__nokCM_persons.id", "readonly", "date");
		$this->addColumnRepresentation("telephone:telephone:#__nokCM_persons:#__nokCM_board.person_id=#__nokCM_persons.id", "readonly", "text");
		$this->addColumnRepresentation("mobile:mobile:#__nokCM_persons:#__nokCM_board.person_id=#__nokCM_persons.id", "readonly", "text");
		$this->addColumnRepresentation("url:url:#__nokCM_persons:#__nokCM_board.person_id=#__nokCM_persons.id", "readonly", "text");
		$this->addColumnRepresentation("email:email:#__nokCM_persons:#__nokCM_board.person_id=#__nokCM_persons.id", "readonly", "text");
		if (strtolower($picdir) != "none") {
			$this->addColumnRepresentation("image:image:#__nokCM_persons:#__nokCM_board.person_id=#__nokCM_persons.id", "readonly", "text");
		}
		$this->addColumnRepresentation("custom1:custom1:#__nokCM_persons:#__nokCM_board.person_id=#__nokCM_persons.id", "readonly", "text");
		$this->addColumnRepresentation("custom2:custom2:#__nokCM_persons:#__nokCM_board.person_id=#__nokCM_persons.id", "readonly", "text");
		$this->addColumnRepresentation("custom3:custom3:#__nokCM_persons:#__nokCM_board.person_id=#__nokCM_persons.id", "readonly", "text");
		$this->addColumnRepresentation("custom4:custom4:#__nokCM_persons:#__nokCM_board.person_id=#__nokCM_persons.id", "readonly", "text");
		$this->addColumnRepresentation("custom5:custom5:#__nokCM_persons:#__nokCM_board.person_id=#__nokCM_persons.id", "readonly", "text");

		//No updatebel columns
		$this->addColumnNoUpdate("id");
		$this->addColumnNoUpdate("createdby");
		$this->addColumnNoUpdate("createddate");

		// Define mandatory fields
		$this->addColumnMandatory("person_id");
		$this->addColumnMandatory("job");
		$this->addColumnMandatory("begin");

		// Define fields and columnname for the list
		$this->addColumnDisplay("list", "name", JText::_( 'TABLE_NOKCM_PERSONS.NAME'));
		$this->addColumnDisplay("list", "firstname", JText::_( 'TABLE_NOKCM_PERSONS.FIRSTNAME'));
		$this->addColumnDisplay("list", "city", JText::_( 'TABLE_NOKCM_PERSONS.CITY'));
		$this->addColumnDisplay("list", "published", JText::_( 'TABLE_NOKCM_BOARD.PUBLISHED'));
		$this->addColumnDisplay("list", "job", JText::_( 'TABLE_NOKCM_BOARD.JOB'));
		$this->addColumnDisplay("list", "begin", JText::_( 'TABLE_NOKCM_BOARD.BEGIN'));
		$this->addColumnDisplay("list", "end", JText::_( 'TABLE_NOKCM_BOARD.END'));
		$this->addColumnDisplay("list", "sortorder", JText::_( 'TABLE_NOKCM_BOARD.SORTORDER'));
		$this->setDefaultOrder("list", "end,sortorder");
		$this->addListFilter("filter_all", "text", "name;firstname;address;zip;city", array());
		$this->addListFilter("filter_published", "select", "published", array("-1" => "FILTER_SELECT_PUBLICITY", "0" => "UNPUBLISHED", "1" => "PUBLISHED"));
		$this->addListFilter("filter_active", "select", "end", array("-1" => "FILTER_SELECT_STATUS", "NULL" => "ACTIVE", "NOT NULL"=>"NOT ACTIVE"));
		$bjob = $this->getSelectionArray("-1=FILTER_SELECT_BOARDJOBS;".$params->get( 'board_jobs' ));
		$this->addListFilter("filter_boardjob", "select", "job", $bjob);

		// Define fields and lables for the detail view
		$this->addColumnDisplay("show", "person_id", JText::_( 'TABLE_NOKCM_BOARD.PERSON_ID'));
		$this->addColumnDisplay("show", "published", JText::_( 'TABLE_NOKCM_BOARD.PUBLISHED'));
		$this->addColumnDisplay("show", "job", JText::_( 'TABLE_NOKCM_BOARD.JOB'));
		$this->addColumnDisplay("show", "begin", JText::_( 'TABLE_NOKCM_BOARD.BEGIN'));
		$this->addColumnDisplay("show", "end", JText::_( 'TABLE_NOKCM_BOARD.END'));
		$this->addColumnDisplay("show", "sortorder", JText::_( 'TABLE_NOKCM_BOARD.SORTORDER'));
		$this->addColumnDisplay("show", "createdby", JText::_( 'TABLE_NOKCM_BOARD.CREATEDBY'));
		$this->addColumnDisplay("show", "createddate", JText::_( 'TABLE_NOKCM_BOARD.CREATEDDATE'));
		$this->addColumnDisplay("show", "modifiedby", JText::_( 'TABLE_NOKCM_BOARD.MODIFIEDBY'));
		$this->addColumnDisplay("show", "modifieddate", JText::_( 'TABLE_NOKCM_BOARD.MODIFIEDDATE'));

		// Define fields and lables for data entry
		$this->addColumnDisplay("edit", "person_id", JText::_( 'TABLE_NOKCM_BOARD.PERSON_ID'));
		$this->addColumnDisplay("edit", "published", JText::_( 'TABLE_NOKCM_BOARD.PUBLISHED'));
		$this->addColumnDisplay("edit", "job", JText::_( 'TABLE_NOKCM_BOARD.JOB'));
		$this->addColumnDisplay("edit", "begin", JText::_( 'TABLE_NOKCM_BOARD.BEGIN'));
		$this->addColumnDisplay("edit", "end", JText::_( 'TABLE_NOKCM_BOARD.END'));
		$this->addColumnDisplay("edit", "sortorder", JText::_( 'TABLE_NOKCM_BOARD.SORTORDER'));
		$this->addColumnDisplay("edit", "createdby", JText::_( 'TABLE_NOKCM_BOARD.CREATEDBY'));
		$this->addColumnDisplay("edit", "createddate", JText::_( 'TABLE_NOKCM_BOARD.CREATEDDATE'));
		$this->addColumnDisplay("edit", "modifiedby", JText::_( 'TABLE_NOKCM_BOARD.MODIFIEDBY'));
		$this->addColumnDisplay("edit", "modifieddate", JText::_( 'TABLE_NOKCM_BOARD.MODIFIEDDATE'));

		// Define fields and columnname for view
		$this->addColumnDisplay("view", "id", JText::_( 'TABLE_NOKCM_BOARD.ID'));
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
		$this->addColumnDisplay("view", "telephone", JText::_( 'TABLE_NOKCM_PERSONS.TELEPHONE'));
		$this->addColumnDisplay("view", "mobile", JText::_( 'TABLE_NOKCM_PERSONS.MOBILE'));
		$this->addColumnDisplay("view", "email", JText::_( 'TABLE_NOKCM_PERSONS.EMAIL'));
		$this->addColumnDisplay("view", "url", JText::_( 'TABLE_NOKCM_PERSONS.URL'));
		$this->addColumnDisplay("view", "published", JText::_( 'TABLE_NOKCM_BOARD.PUBLISHED'));
		$this->addColumnDisplay("view", "job", JText::_( 'TABLE_NOKCM_BOARD.JOB'));
		$this->addColumnDisplay("view", "begin", JText::_( 'TABLE_NOKCM_BOARD.BEGIN'));
		$this->addColumnDisplay("view", "end", JText::_( 'TABLE_NOKCM_BOARD.END'));
		$this->addColumnDisplay("view", "beginyear", JText::_( 'TABLE_NOKCM_BOARD.BEGINYEAR'));
		$this->addColumnDisplay("view", "endyear", JText::_( 'TABLE_NOKCM_BOARD.ENDYEAR'));
		$this->addColumnDisplay("view", "beginendyear", JText::_( 'TABLE_NOKCM_BOARD.BEGINENDYEAR'));
		$this->addColumnDisplay("view", "sortorder", JText::_( 'TABLE_NOKCM_BOARD.SORTORDER'));
		if (strtolower($picdir) != "none") {
			$this->addColumnDisplay("view", "image", JText::_( 'TABLE_NOKCM_PERSONS.IMAGE'));
		}

		// Define fields for export
		$this->addExportColumn("published","Y");
		$this->addExportColumn("job","Y");
		$this->addExportColumn("sortorder","Y");
		$this->addExportColumn("begin","Y");
		$this->addExportColumn("end","Y");
		$this->addExportColumn("name","N");
		$this->addExportColumn("firstname","N");
		$this->addExportColumn("address","N");
		$this->addExportColumn("city","N");
		$this->addExportColumn("birthday","N");
		$this->setImportForeignKey("name:firstname:address:city:birthday", "person_id", "#__nokCM_persons", "name:firstname:address:city:birthday", "id");
		$this->setImportPrimaryKey("person_id:job:begin");

		// Define toolbar itemms
		$this->addToolbarEntry("publish");
		$this->addToolbarEntry("unpublish");
		$this->addToolbarEntry("add");
		$this->addToolbarEntry("edit");
		$this->addToolbarEntry("delete");
		$this->addToolbarEntry("export");
		$this->addToolbarEntry("import");
		$this->addToolbarEntry("preferences");
		$this->addToolbarEntry("help");
	}
}
?>