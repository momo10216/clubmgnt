<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Board
* @copyright	Copyright (c) 2014 Norbert Kuemin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
 
jimport('joomla.form.formfield');
use Joomla\CMS\Language\Text;

// The class name must always be the same as the filename (in camel case)
class JFormFieldCmBoardColumn extends JFormField {

    //The field class must know its own type through the variable $type.
    protected $type = 'cmboardcolumn';
 
    public function getInput() {
		$param = JComponentHelper::getParams('com_clubmanagement');
		$fields = array(
			"" => Text::_('COM_CLUBMANAGEMENT_SELECT_FIELD'),
			"board_id" => Text::_('COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_ID_LABEL'),
			"person_id" => Text::_('COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_PERSON_ID_LABEL'),
			"person_fullname" => Text::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_FULLNAME_LABEL'),
			"person_salutation" => Text::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_SALUTATION_LABEL'),
			"person_firstname" => Text::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_FIRSTNAME_LABEL'),
			"person_middlename" => Text::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_MIDDLENAME_LABEL'),
			"person_name" => Text::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_NAME_LABEL'),
			"person_birthname" => Text::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_BIRTHNAME_LABEL'),
			"person_nickname" => Text::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_NICKNAME_LABEL'),
			"person_nickfirstname" => Text::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_NICKFIRSTNAME_LABEL'),
			"person_address" => Text::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_ADDRESS_LABEL'),
			"person_city" => Text::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_CITY_LABEL'),
			"person_zip" => Text::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_ZIP_LABEL'),
			"person_state" => Text::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_STATE_LABEL'),
			"person_country" => Text::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_COUNTRY_LABEL'),
			"person_telephone" => Text::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_TELEPHONE_LABEL'),
			"person_mobile" => Text::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_MOBILE_LABEL'),
			"person_url" => Text::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_URL_LABEL'),
			"person_email" => Text::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_EMAIL_LABEL'),
			"user_username" => Text::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_USERNAME_LABEL'),
			"person_description" => Text::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_DESCRIPTION_LABEL'),
			"person_image" => Text::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_IMAGE_LABEL'),
			"person_birthday" => Text::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_BIRTHDAY_LABEL'),
			"person_nextbirthday" => Text::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_NEXT_BIRTHDAY_LABEL'),
			"person_deceased" => Text::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_DECEASED_LABEL'),
			"person_custom1" => $param->get('custom1'),
			"person_custom2" => $param->get('custom2'),
			"person_custom3" => $param->get('custom3'),
			"person_custom4" => $param->get('custom4'),
			"person_custom5" => $param->get('custom5'),
			"board_job" => Text::_('COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_JOB_LABEL'),
			"board_begin" => Text::_('COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_BEGIN_LABEL'),
			"board_end" => Text::_('COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_END_LABEL'),
			"board_beginyear" => Text::_('COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_BEGINYEAR_LABEL'),
			"board_endyear" => Text::_('COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_ENDYEAR_LABEL'),
			"board_beginendyear" => Text::_('COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_BEGINENDYEAR_LABEL'),
			"board_published" => Text::_('COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_PUBLISHED_LABEL'),
			"board_sortorder" => Text::_('COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_SORTORDER_LABEL'),
			"board_createdby" => Text::_('COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_CREATEDBY_LABEL'),
			"board_createddate" => Text::_('COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_CREATEDDATE_LABEL'),
			"board_modifiedby" => Text::_('COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_MODIFIEDBY_LABEL'),
			"board_modifieddate" => Text::_('COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_MODIFIEDDATE_LABEL'),
			"category_title" => Text::_('COM_CLUBMANAGEMENT_CATEGORIES_FIELD_TITLE_LABEL'),
			"category_alias" => Text::_('COM_CLUBMANAGEMENT_CATEGORIES_FIELD_ALIAS_LABEL'),
			"category_path" => Text::_('COM_CLUBMANAGEMENT_CATEGORIES_FIELD_PATH_LABEL')
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
?>
