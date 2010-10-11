<?php
/**
* @version		0.95
* @package		Joomla
* @subpackage	ClubManagement-Membership
* @copyright	Copyright (c) 2009 Norbert K�min. All rights reserved.
* @license		http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author		Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

// Define object b ased on the table object
require_once( dirname(__FILE__).DS.'nokTable.class.php');

class nokCMMembership extends nokTable {

	function nokCMMembership($component) {
		$this->nokTable('#__nokCM_memberships','membership');

		// Table columns
		$this->addTableColumn("id", "int(11) unsigned", "N", "", "auto_increment");
		$this->addTableColumn("person_id", "int(11) unsigned", "N", "0", "");
		$this->addTableColumn("type", "varchar(25)", "N", "", "");
		$this->addTableColumn("begin", "date", "N", "", "");
		$this->addTableColumn("end", "date", "Y", "", "");
		$this->addTableColumn("published", "int(1)", "N", "0", "");
		$this->addTableColumn("createdby", "varchar(50)", "Y", "", "");
		$this->addTableColumn("createddate", "datetime", "Y", "", "");
		$this->addTableColumn("modifiedby", "varchar(50)", "Y", "", "");
		$this->addTableColumn("modifieddate", "datetime", "Y", "", "");
		$this->addTableIndex("person_id", "person_id", "N");

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
		$this->addColumnRepresentation("type", "textselect", $params->get( 'member_types' ));
		$this->addColumnRepresentation("begin", "date");
		$this->addColumnRepresentation("end", "date");
		$this->addColumnRepresentation("beginyear:YEAR(#__nokCM_memberships.`begin`)", "readonly", "text");
		$this->addColumnRepresentation("endyear:YEAR(#__nokCM_memberships.`end`)", "readonly", "text");
		$this->addColumnRepresentation("beginendyear:CONCAT(YEAR(#__nokCM_memberships.`begin`),'-',IFNULL(YEAR(#__nokCM_memberships.`end`),''))", "readonly", "text");
		$this->addColumnRepresentation("createdby", "readonly", "text", "CurrentUser");
		$this->addColumnRepresentation("createddate", "readonly", "datetime", "CurrentDate");
		$this->addColumnRepresentation("modifiedby", "readonly", "text", "CurrentUser");
		$this->addColumnRepresentation("modifieddate", "readonly", "datetime", "CurrentDate");
		$this->addColumnRepresentation("salutation:salutation:#__nokCM_persons:#__nokCM_memberships.person_id=#__nokCM_persons.id", "readonly", "text");
		$this->addColumnRepresentation("name:name:#__nokCM_persons:#__nokCM_memberships.person_id=#__nokCM_persons.id", "readonly", "text");
		$this->addColumnRepresentation("birthname:birthname:#__nokCM_persons:#__nokCM_memberships.person_id=#__nokCM_persons.id", "readonly", "text");
		$this->addColumnRepresentation("firstname:firstname:#__nokCM_persons:#__nokCM_memberships.person_id=#__nokCM_persons.id", "readonly", "text");
		$this->addColumnRepresentation("middlename:middlename:#__nokCM_persons:#__nokCM_memberships.person_id=#__nokCM_persons.id", "readonly", "text");
		$this->addColumnRepresentation("nickname:nickname:#__nokCM_persons:#__nokCM_memberships.person_id=#__nokCM_persons.id", "readonly", "text");
		$this->addColumnRepresentation("nickfirstname:IFNULL(#__nokCM_persons.`nickname`,#__nokCM_persons.`firstname`):#__nokCM_persons:#__nokCM_memberships.person_id=#__nokCM_persons.id", "readonly", "text");
		$this->addColumnRepresentation("address:address:#__nokCM_persons:#__nokCM_memberships.person_id=#__nokCM_persons.id", "readonly", "text");
		$this->addColumnRepresentation("city:city:#__nokCM_persons:#__nokCM_memberships.person_id=#__nokCM_persons.id", "readonly", "text");
		$this->addColumnRepresentation("zip:zip:#__nokCM_persons:#__nokCM_memberships.person_id=#__nokCM_persons.id", "readonly", "text");
		$this->addColumnRepresentation("country:country:#__nokCM_persons:#__nokCM_memberships.person_id=#__nokCM_persons.id", "readonly", "text");
		$this->addColumnRepresentation("state:state:#__nokCM_persons:#__nokCM_memberships.person_id=#__nokCM_persons.id", "readonly", "text");
		$this->addColumnRepresentation("hh_person_id:hh_person_id:#__nokCM_persons:#__nokCM_memberships.person_id=#__nokCM_persons.id", "readonly", "text");
		$this->addColumnRepresentation("hh_salutation_override:hh_salutation_override:#__nokCM_persons:#__nokCM_memberships.person_id=#__nokCM_persons.id", "readonly", "text");
		$this->addColumnRepresentation("hh_name_override:hh_name_override:#__nokCM_persons:#__nokCM_memberships.person_id=#__nokCM_persons.id", "readonly", "text");
		$this->addColumnRepresentation("birthday:birthday:#__nokCM_persons:#__nokCM_memberships.person_id=#__nokCM_persons.id", "readonly", "date");
		$this->addColumnRepresentation("abirthday:IF(DATE_ADD(#__nokCM_persons.`birthday`, INTERVAL (YEAR(NOW()) - YEAR(#__nokCM_persons.`birthday`)) YEAR) < CURDATE(),DATE_ADD(#__nokCM_persons.`birthday`, INTERVAL (YEAR(NOW()) - YEAR(#__nokCM_persons.`birthday`) + 1) YEAR),DATE_ADD(#__nokCM_persons.`birthday`, INTERVAL (YEAR(NOW()) - YEAR(#__nokCM_persons.`birthday`)) YEAR)):#__nokCM_persons:#__nokCM_memberships.person_id=#__nokCM_persons.id", "readonly", "date");
		$this->addColumnRepresentation("deceased:deceased:#__nokCM_persons:#__nokCM_memberships.person_id=#__nokCM_persons.id", "readonly", "date");
		$this->addColumnRepresentation("telephone:telephone:#__nokCM_persons:#__nokCM_memberships.person_id=#__nokCM_persons.id", "readonly", "text");
		$this->addColumnRepresentation("mobile:mobile:#__nokCM_persons:#__nokCM_memberships.person_id=#__nokCM_persons.id", "readonly", "text");
		$this->addColumnRepresentation("url:url:#__nokCM_persons:#__nokCM_memberships.person_id=#__nokCM_persons.id", "readonly", "url");
		$this->addColumnRepresentation("email:email:#__nokCM_persons:#__nokCM_memberships.person_id=#__nokCM_persons.id", "readonly", "email");
		if (strtolower($picdir) != "none") {
			$this->addColumnRepresentation("image:image:#__nokCM_persons:#__nokCM_memberships.person_id=#__nokCM_persons.id", "readonly", "image");
		}
		$this->addColumnRepresentation("custom1:custom1:#__nokCM_persons:#__nokCM_memberships.person_id=#__nokCM_persons.id", "readonly", "text");
		$this->addColumnRepresentation("custom2:custom2:#__nokCM_persons:#__nokCM_memberships.person_id=#__nokCM_persons.id", "readonly", "text");
		$this->addColumnRepresentation("custom3:custom3:#__nokCM_persons:#__nokCM_memberships.person_id=#__nokCM_persons.id", "readonly", "text");
		$this->addColumnRepresentation("custom4:custom4:#__nokCM_persons:#__nokCM_memberships.person_id=#__nokCM_persons.id", "readonly", "text");
		$this->addColumnRepresentation("custom5:custom5:#__nokCM_persons:#__nokCM_memberships.person_id=#__nokCM_persons.id", "readonly", "text");

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
		$this->addColumnMandatory("person_id");
		$this->addColumnMandatory("type");
		$this->addColumnMandatory("begin");

		// Define fields and columnname for the list
		$this->addColumnDisplay("list", "name", JText::_( 'TABLE_NOKCM_PERSONS.NAME'));
		$this->addColumnDisplay("list", "firstname", JText::_( 'TABLE_NOKCM_PERSONS.FIRSTNAME'));
		$this->addColumnDisplay("list", "city", JText::_( 'TABLE_NOKCM_PERSONS.CITY'));
		$this->addColumnDisplay("list", "published", JText::_( 'TABLE_NOKCM_MEMBERSHIPS.PUBLISHED'));
		$this->addColumnDisplay("list", "type", JText::_( 'TABLE_NOKCM_MEMBERSHIPS.TYPE'));
		$this->addColumnDisplay("list", "begin", JText::_( 'TABLE_NOKCM_MEMBERSHIPS.BEGIN'));
		$this->addColumnDisplay("list", "end", JText::_( 'TABLE_NOKCM_MEMBERSHIPS.END'));
		$this->setDefaultOrder("list", "IF(end IS NULL,0,1), type, name, firstname, city");
		$this->addListFilter("filter_all", "text", "name;firstname;address;zip;city", array());
		$this->addListFilter("filter_published", "select", "published", array("-1" => "FILTER_SELECT_PUBLICITY", "0" => "UNPUBLISHED", "1" => "PUBLISHED"));
		$this->addListFilter("filter_active", "select", "end", array("-1" => "FILTER_SELECT_STATUS", "NULL" => "ACTIVE", "NOT NULL"=>"NOT ACTIVE"));
		$mtype = $this->getSelectionArray("-1=FILTER_SELECT_MEMBERTYPE;".$params->get( 'member_types' ));
		$this->addListFilter("filter_membertype", "select", "type", $mtype);

		// Define fields and lables for the detail view
		$this->addColumnDisplay("show", "person_id", JText::_( 'TABLE_NOKCM_MEMBERSHIPS.PERSON_ID'));
		$this->addColumnDisplay("show", "published", JText::_( 'TABLE_NOKCM_MEMBERSHIPS.PUBLISHED'));
		$this->addColumnDisplay("show", "type", JText::_( 'TABLE_NOKCM_MEMBERSHIPS.TYPE'));
		$this->addColumnDisplay("show", "begin", JText::_( 'TABLE_NOKCM_MEMBERSHIPS.BEGIN'));
		$this->addColumnDisplay("show", "end", JText::_( 'TABLE_NOKCM_MEMBERSHIPS.END'));
		$this->addColumnDisplay("show", "createdby", JText::_( 'TABLE_NOKCM_MEMBERSHIPS.CREATEDBY'));
		$this->addColumnDisplay("show", "createddate", JText::_( 'TABLE_NOKCM_MEMBERSHIPS.CREATEDDATE'));
		$this->addColumnDisplay("show", "modifiedby", JText::_( 'TABLE_NOKCM_MEMBERSHIPS.MODIFIEDBY'));
		$this->addColumnDisplay("show", "modifieddate", JText::_( 'TABLE_NOKCM_MEMBERSHIPS.MODIFIEDDATE'));

		// Define fields and lables for data entry
		$this->addColumnDisplay("edit", "person_id", JText::_( 'TABLE_NOKCM_MEMBERSHIPS.PERSON_ID'));
		$this->addColumnDisplay("edit", "published", JText::_( 'TABLE_NOKCM_MEMBERSHIPS.PUBLISHED'));
		$this->addColumnDisplay("edit", "type", JText::_( 'TABLE_NOKCM_MEMBERSHIPS.TYPE'));
		$this->addColumnDisplay("edit", "begin", JText::_( 'TABLE_NOKCM_MEMBERSHIPS.BEGIN'));
		$this->addColumnDisplay("edit", "end", JText::_( 'TABLE_NOKCM_MEMBERSHIPS.END'));
		$this->addColumnDisplay("edit", "createdby", JText::_( 'TABLE_NOKCM_MEMBERSHIPS.CREATEDBY'));
		$this->addColumnDisplay("edit", "createddate", JText::_( 'TABLE_NOKCM_MEMBERSHIPS.CREATEDDATE'));
		$this->addColumnDisplay("edit", "modifiedby", JText::_( 'TABLE_NOKCM_MEMBERSHIPS.MODIFIEDBY'));
		$this->addColumnDisplay("edit", "modifieddate", JText::_( 'TABLE_NOKCM_MEMBERSHIPS.MODIFIEDDATE'));

		// Define fields and columnname for view
		$this->addColumnDisplay("view", "id", JText::_( 'TABLE_NOKCM_MEMBERSHIPS.ID'));
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
		$this->addColumnDisplay("view", "custom1", JText::_( $params->get( 'custom1' )));
		$this->addColumnDisplay("view", "custom2", JText::_( $params->get( 'custom2' )));
		$this->addColumnDisplay("view", "custom3", JText::_( $params->get( 'custom3' )));
		$this->addColumnDisplay("view", "custom4", JText::_( $params->get( 'custom4' )));
		$this->addColumnDisplay("view", "custom5", JText::_( $params->get( 'custom5' )));
		$this->addColumnDisplay("view", "published", JText::_( 'TABLE_NOKCM_BOARD.PUBLISHED'));
		$this->addColumnDisplay("view", "type", JText::_( 'TABLE_NOKCM_MEMBERSHIPS.TYPE'));
		$this->addColumnDisplay("view", "begin", JText::_( 'TABLE_NOKCM_MEMBERSHIPS.BEGIN'));
		$this->addColumnDisplay("view", "end", JText::_( 'TABLE_NOKCM_MEMBERSHIPS.END'));
		$this->addColumnDisplay("view", "beginyear", JText::_( 'TABLE_NOKCM_MEMBERSHIPS.BEGINYEAR'));
		$this->addColumnDisplay("view", "endyear", JText::_( 'TABLE_NOKCM_MEMBERSHIPS.ENDYEAR'));
		$this->addColumnDisplay("view", "beginendyear", JText::_( 'TABLE_NOKCM_MEMBERSHIPS.BEGINENDYEAR'));
		if (strtolower($picdir) != "none") {
			$this->addColumnDisplay("view", "image", JText::_( 'TABLE_NOKCM_PERSONS.IMAGE'));
		}

		// Define fields for export
		$this->addExportColumn("published","Y");
		$this->addExportColumn("type","Y");
		$this->addExportColumn("begin","Y");
		$this->addExportColumn("end","Y");
		$this->addExportColumn("name","N");
		$this->addExportColumn("firstname","N");
		$this->addExportColumn("address","N");
		$this->addExportColumn("city","N");
		$this->addExportColumn("birthday","N");
		$this->setImportForeignKey("name:firstname:address:city:birthday", "person_id", "#__nokCM_persons", "name:firstname:address:city:birthday", "id");
		$this->setImportPrimaryKey("person_id:type:begin");

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

	function getMemberTypes () {
		$params = &JComponentHelper::getParams('com_clubmanagement');
		return $this->getSelectionArray($params->get('member_types'));
	}
}
?>