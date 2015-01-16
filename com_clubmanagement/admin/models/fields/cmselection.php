<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Tools
* @copyright	Copyright (c) 2014 Norbert Kümin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
 
jimport('joomla.form.formfield');
 
// The class name must always be the same as the filename (in camel case)
class JFormFieldCmSelection extends JFormField {
 
        //The field class must know its own type through the variable $type.
        protected $type = 'cmselection';
 
        public function getInput() {
		$app = &JFactory::getApplication();
		$params = JComponentHelper::getParams('com_clubmanagement');
		$selectionText = $params->get($this->element["paramname"]);
		$selectionRows = explode(";",$selectionText);
		$fields = array();
		if ($this->element["hide_none"] != "true") {
			$fields[""] = JText::alt('JOPTION_DO_NOT_USE', preg_replace('/[^a-zA-Z0-9_\-]/', '_', $this->fieldname));
		}
		$multiple = '';
		if ($this->element['multiple'] == 'true') {
			$multiple = 'multiple ';
		}
		foreach($selectionRows as $selectionRow) {
			$values = explode("=",$selectionRow,2);
			$fields[$values[0]] = $values[1];
		}
		if (is_array($this->value)) {
			$values = $this->value;
		} else {
			$values = array($this->value);
			if (!array_key_exists($this->value, $fields)) {
				$fields[$this->value] = $this->value;
			}
		}
		$option = "";
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
