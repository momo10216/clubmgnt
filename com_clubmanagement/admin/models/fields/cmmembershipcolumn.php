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

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
 
jimport('joomla.form.formfield');
 
// The class name must always be the same as the filename (in camel case)
class JFormFieldCmMembershipColumn extends JFormField {
 
        //The field class must know its own type through the variable $type.
        protected $type = 'cmmembershipcolumn';
 
        public function getInput() {
		$fields = array(
			"" => JText::_('COM_CLUBMANAGEMENT_SELECT_FIELD'),
			"member_id" => JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_ID_LABEL'),
			"person_salutation" => JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_SALUTATION_LABEL'),
			"person_firstname" => JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_FIRSTNAME_LABEL'),
			"person_middlename" => JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_MIDDLENAME_LABEL'),
			"person_name" => JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_NAME_LABEL'),
			"person_birthname" => JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_BIRTHNAME_LABEL'),
			"person_nickname" => JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_NICKNAME_LABEL'),
			"person_address" => JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_ADDRESS_LABEL'),
			"person_city" => JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_CITY_LABEL'),
			"person_zip" => JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_ZIP_LABEL'),
			"person_state" => JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_STATE_LABEL'),
			"person_country" => JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_COUNTRY_LABEL'),
			"person_telephone" => JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_TELEPHONE_LABEL'),
			"person_mobile" => JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_MOBILE_LABEL'),
			"person_url" => JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_URL_LABEL'),
			"person_email" => JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_EMAIL_LABEL'),
			"user_username" => JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_USERNAME_LABEL'),
			"person_description" => JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_DESCRIPTION_LABEL'),
			"person_image" => JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_IMAGE_LABEL'),
			"person_birthday" => JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_BIRTHDAY_LABEL'),
			"person_deceased" => JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_DECEASED_LABEL'),
			"person_custom1" => JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_CUSTOM1_LABEL'),
			"person_custom2" => JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_CUSTOM2_LABEL'),
			"person_custom3" => JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_CUSTOM3_LABEL'),
			"person_custom4" => JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_CUSTOM4_LABEL'),
			"person_custom5" => JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_CUSTOM5_LABEL'),
			"member_type" => JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_TYPE_LABEL'),
			"member_begin" => JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_BEGIN_LABEL'),
			"member_end" => JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_END_LABEL'),
			"member_beginyear" => JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_BEGINYEAR_LABEL'),
			"member_endyear" => JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_ENDYEAR_LABEL'),
			"member_beginendyear" => JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_BEGINENDYEAR_LABEL'),
			"member_published" => JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_PUBLISHED_LABEL'),
			"member_createdby" => JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_CREATEDBY_LABEL'),
			"member_createddate" => JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_CREATEDDATE_LABEL'),
			"member_modifiedby" => JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_MODIFIEDBY_LABEL'),
			"member_modifieddate" => JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_MODIFIEDDATE_LABEL')
		);
		$option = '';
		$multiple = '';
		if ($this->element['multiple'] == 'true') {
			$multiple = 'multiple ';
		}
		if (is_array($this->value)) {
			$values = $this->value;
		} else {
			$values = array($this->value);
		}
		foreach(array_keys($fields) as $key) {
			$option .= '<option value="'.$key.'"';
			if (array_search($key,$values) !== false)  {
				$option .= ' selected';
			}
			$option .= '>'.$fields[$key].'</option>';
		}
		return '<select '.$multiple.'id="'.$this->id.'" name="'.$this->name.'">'.$option.'</select>';
        }
}
