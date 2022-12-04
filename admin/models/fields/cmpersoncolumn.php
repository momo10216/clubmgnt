<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Person
* @copyright	Copyright (c) 2014 Norbert Kuemin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.form.formfield');
use Joomla\CMS\Version;
use Joomla\CMS\Language\Text;

// The class name must always be the same as the filename (in camel case)
class JFormFieldCmPersonColumn extends JFormField {
    //The field class must know its own type through the variable $type.
    protected $type = 'cmpersoncolumn';

    public function getInput() {
		$param = JComponentHelper::getParams('com_clubmanagement');
		$fields = array(
			"" => self::translate('COM_CLUBMANAGEMENT_SELECT_FIELD'),
			"person_id" => self::translate('COM_CLUBMANAGEMENT_PERSONS_FIELD_ID_LABEL'),
			"person_salutation" => self::translate('COM_CLUBMANAGEMENT_PERSONS_FIELD_SALUTATION_LABEL'),
			"person_firstname" => self::translate('COM_CLUBMANAGEMENT_PERSONS_FIELD_FIRSTNAME_LABEL'),
			"person_middlename" => self::translate('COM_CLUBMANAGEMENT_PERSONS_FIELD_MIDDLENAME_LABEL'),
			"person_name" => self::translate('COM_CLUBMANAGEMENT_PERSONS_FIELD_NAME_LABEL'),
			"person_birthname" => self::translate('COM_CLUBMANAGEMENT_PERSONS_FIELD_BIRTHNAME_LABEL'),
			"person_nickname" => self::translate('COM_CLUBMANAGEMENT_PERSONS_FIELD_NICKNAME_LABEL'),
			"person_nickfirstname" => self::translate('COM_CLUBMANAGEMENT_PERSONS_FIELD_NICKFIRSTNAME_LABEL'),
			"person_address" => self::translate('COM_CLUBMANAGEMENT_PERSONS_FIELD_ADDRESS_LABEL'),
			"person_city" => self::translate('COM_CLUBMANAGEMENT_PERSONS_FIELD_CITY_LABEL'),
			"person_zip" => self::translate('COM_CLUBMANAGEMENT_PERSONS_FIELD_ZIP_LABEL'),
			"person_state" => self::translate('COM_CLUBMANAGEMENT_PERSONS_FIELD_STATE_LABEL'),
			"person_country" => self::translate('COM_CLUBMANAGEMENT_PERSONS_FIELD_COUNTRY_LABEL'),
			"person_telephone" => self::translate('COM_CLUBMANAGEMENT_PERSONS_FIELD_TELEPHONE_LABEL'),
			"person_mobile" => self::translate('COM_CLUBMANAGEMENT_PERSONS_FIELD_MOBILE_LABEL'),
			"person_url" => self::translate('COM_CLUBMANAGEMENT_PERSONS_FIELD_URL_LABEL'),
			"person_email" => self::translate('COM_CLUBMANAGEMENT_PERSONS_FIELD_EMAIL_LABEL'),
			"user_username" => self::translate('COM_CLUBMANAGEMENT_PERSONS_FIELD_USERNAME_LABEL'),
			"person_description" => self::translate('COM_CLUBMANAGEMENT_PERSONS_FIELD_DESCRIPTION_LABEL'),
			"person_image" => self::translate('COM_CLUBMANAGEMENT_PERSONS_FIELD_IMAGE_LABEL'),
			"person_birthday" => self::translate('COM_CLUBMANAGEMENT_PERSONS_FIELD_BIRTHDAY_LABEL'),
			"person_nextbirthday" => self::translate('COM_CLUBMANAGEMENT_PERSONS_FIELD_NEXT_BIRTHDAY_LABEL'),
			"person_deceased" => self::translate('COM_CLUBMANAGEMENT_PERSONS_FIELD_DECEASED_LABEL'),
			"person_custom1" => $param->get('custom1'),
			"person_custom2" => $param->get('custom2'),
			"person_custom3" => $param->get('custom3'),
			"person_custom4" => $param->get('custom4'),
			"person_custom5" => $param->get('custom5'),
			"person_createdby" => self::translate('COM_CLUBMANAGEMENT_PERSONS_FIELD_CREATEDBY_LABEL'),
			"person_createddate" => self::translate('COM_CLUBMANAGEMENT_PERSONS_FIELD_CREATEDDATE_LABEL'),
			"person_modifiedby" => self::translate('COM_CLUBMANAGEMENT_PERSONS_FIELD_MODIFIEDBY_LABEL'),
			"person_modifieddate" => self::translate('COM_CLUBMANAGEMENT_PERSONS_FIELD_MODIFIEDDATE_LABEL')
		);
		$option = "";
		$multiple = '';
		if (is_array($this->value)) {
			$values = $this->value;
		} else {
			$values = array($this->value);
		}
		if (isset($this->element['multiple']) && ($this->element['multiple'] == 'true')) {
			$multiple = 'multiple ';
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

	protected static function translate($key) {
        if (Version::MAJOR_VERSION == '3') {
            return JText::_($key);
        } elseif (Version::MAJOR_VERSION == '4') {
            return Text::_($key);
        }
        return $key;
	}
}
?>
