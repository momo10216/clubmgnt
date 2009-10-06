<?php
/**
* @version		0.5
* @package		Joomla
* @subpackage	ClubManagement-Person
* @copyright	Copyright (c) 2009 Norbert Kümin. All rights reserved.
* @license		http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author		Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

// Define object b ased on the table object
require_once( dirname(__FILE__).DS.'nokTable.class.php');

class nokCMPerson extends nokTable
{
	function nokCMPerson($component)
	{
		$this->nokTable('#__nokCM_persons','person');
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
		$this->addColumnRepresentation("address", "text", 50, 100);
		$this->addColumnRepresentation("zip", "text", 50, 50);
		$this->addColumnRepresentation("city", "text", 50, 50);
		$this->addColumnRepresentation("state", "text", 50, 100);
		$this->addColumnRepresentation("country", "text", 50, 100);
		$this->addColumnRepresentation("birthday", "date");
		$this->addColumnRepresentation("deceased", "date");
		$this->addColumnRepresentation("telephone", "text", 25, 25);
		$this->addColumnRepresentation("mobile", "text", 25, 25);
		$this->addColumnRepresentation("email", "email", 50, 100);
		$this->addColumnRepresentation("url", "url", 50, 250);
		$this->addColumnRepresentation("user_id", "selection", "id", "username", "#__users", "", "username", JText::_( 'SELECTION_NONE'));
		if (strtolower($picdir) != "none") {
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
		$this->addColumnRepresentation("modifiedby", "readonly", "text", "", "CurrentUser");
		$this->addColumnRepresentation("modifieddate", "readonly", "datetime", "", "CurrentDate");

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
		$this->addColumnDisplay("show", "birthday", JText::_( 'TABLE_NOKCM_PERSONS.BIRTHDAY'));
		$this->addColumnDisplay("show", "deceased", JText::_( 'TABLE_NOKCM_PERSONS.DECEASED'));
		$this->addColumnDisplay("show", "telephone", JText::_( 'TABLE_NOKCM_PERSONS.TELEPHONE'));
		$this->addColumnDisplay("show", "mobile", JText::_( 'TABLE_NOKCM_PERSONS.MOBILE'));
		$this->addColumnDisplay("show", "email", JText::_( 'TABLE_NOKCM_PERSONS.EMAIL'));
		$this->addColumnDisplay("show", "url", JText::_( 'TABLE_NOKCM_PERSONS.URL'));
		$this->addColumnDisplay("show", "user_id", JText::_( 'TABLE_NOKCM_PERSONS.USER_ID'));
		if (strtolower($picdir) != "none") {
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
		$this->addColumnDisplay("edit", "birthday", JText::_( 'TABLE_NOKCM_PERSONS.BIRTHDAY'));
		$this->addColumnDisplay("edit", "deceased", JText::_( 'TABLE_NOKCM_PERSONS.DECEASED'));
		$this->addColumnDisplay("edit", "telephone", JText::_( 'TABLE_NOKCM_PERSONS.TELEPHONE'));
		$this->addColumnDisplay("edit", "mobile", JText::_( 'TABLE_NOKCM_PERSONS.MOBILE'));
		$this->addColumnDisplay("edit", "email", JText::_( 'TABLE_NOKCM_PERSONS.EMAIL'));
		$this->addColumnDisplay("edit", "url", JText::_( 'TABLE_NOKCM_PERSONS.URL'));
		$this->addColumnDisplay("edit", "user_id", JText::_( 'TABLE_NOKCM_PERSONS.USER_ID'));
		if (strtolower($picdir) != "none") {
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
}
?>