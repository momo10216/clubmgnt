<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Main
* @copyright	Copyright (c) 2015 Norbert Kuemin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
 
jimport('joomla.form.formfield');
 
// The class name must always be the same as the filename (in camel case)
class JFormFieldCmImageList extends JFormField {
        //The field class must know its own type through the variable $type.
        protected $type = 'cmimagelist';
 
        public function getInput() {
		$param = JComponentHelper::getParams('com_clubmanagement');
		$dir = JPATH_ROOT.$param->get('image_dir');
		$option = '';
		$multiple = '';
		if (isset($this->element['multiple']) && ($this->element['multiple'] == 'true')) {
			$multiple = 'multiple ';
		}
		if (is_array($this->value)) {
			$values = $this->value;
		} else {
			$values = array($this->value);
		}
		$files = array("");
		if ($handle = opendir($dir)) {
			while (false !== ($file = readdir($handle))) {
				if (!is_dir($dir. "/" . $file)) {
					$files[] = $file;
				}
			}
			closedir($handle);
		}
		asort($files);
		foreach($files as $file) {
			$option .= '<option value="'.$file.'"';
			if (array_search($file,$values) !== false)  {
				$option .= ' selected';
			}
			$option .= '>'.$file.'</option>';
		}
		return '<select '.$multiple.'id="'.$this->id.'" name="'.$this->name.'">'.$option.'</select>';
        }
}
?>
