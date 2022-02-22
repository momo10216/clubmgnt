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
//defined('JPATH_BASE') or die;

/**
 * Supports a modal person picker.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_clubmanagement
 * @since       3.0
 */
class JFormFieldModal_Persons extends JFormField {
	protected $type = 'Modal_Persons';

	protected function getInput() {
		// Load the modal behavior script.
		JHtml::_('behavior.modal', 'a.modal');
		// Build the script.
		$script = array();
		// Select button script
		$script[] = '	function jSelectPerson_'.$this->id.'(id, name, firstname, address, city) {';
		$script[] = '		document.getElementById("'.$this->id.'_id").value = id;';
		$script[] = '		document.getElementById("'.$this->id.'_name").value = name+", "+firstname+", "+address+", "+city;';
		$script[] = '		SqueezeBox.close();';
		$script[] = '	}';
		$script[] = '	function jClearPerson_'.$this->id.'(id) {';
		$script[] = '		document.getElementById("'.$this->id.'_id").value = "";';
		$script[] = '		document.getElementById("'.$this->id.'_name").value = "";';
		$script[] = '	}';
		// Add the script to the document head.
		JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));
		// Setup variables for display.
		$html	= array();
		$link	= 'index.php?option=com_clubmanagement&amp;view=persons&amp;layout=modal&amp;tmpl=component&amp;function=jSelectPerson_'.$this->id;
		if (isset($this->element["household"]) && ($this->element["household"] == "true")) {
			$link .= "&amp;hh=true";
		}
		if (isset($this->element["excludeCurrentId"]) && ($this->element["excludeCurrentId"] == "true")) {
			$app = JFactory::getApplication();
			if ($id = $app->input->get('id')) {
				$link .= "&amp;excludeid=".$id;
			}
		}
		if ((int) $this->value > 0) {
			$db	= JFactory::getDbo();
			$query = $db->getQuery(true)
				->select("CONCAT(IFNULL(name,''),' ',IFNULL(firstname,''),',',',',IFNULL(address,''),',',IFNULL(city,''))")
				->from($db->quoteName('#__nokCM_persons'))
				->where($db->quoteName('id') . ' = ' . (int) $this->value);
			$db->setQuery($query);
			try {
				$fullname = $db->loadResult();
			} catch (RuntimeException $e) {
				JError::raiseWarning(500, $e->getMessage());
			}
		}

		if (empty($fullname)) {
			$fullname = JText::_('COM_CLUBMANAGEMENT_SELECT_A_PERSON');
		}
		$title = htmlspecialchars($fullname, ENT_QUOTES, 'UTF-8');
		// The active article id field.
		if (0 == (int) $this->value) { $value = ''; } else { $value = (int) $this->value;}
		// The current article display field.
		$html[] = '<span class="input-append">';
		$html[] = '<input type="text" class="input-medium" id="'.$this->id.'_name" value="'.$fullname.'" disabled="disabled" size="35" />';
		if (isset($this->element['select']) && ($this->element['select'] == 'true')) {
			$html[] = '<a class="modal btn hasTooltip" title="'.JHtml::tooltipText('COM_CLUBMANAGEMENT_CHANGE_PERSON').'"  href="'.$link.'&amp;'.JSession::getFormToken().'=1" rel="{handler: \'iframe\', size: {x: 800, y: 450}}"><i class="icon-file"></i> '.JText::_('JSELECT').'</a>';
		}
		if (isset($this->element['clear']) && ($this->element['clear'] == 'true')) {
			$html[] = '<button type="button" class="btn" id="' . $this->id . '_clear" onclick="window.jClearPerson_' . $this->id . '(\'' . $this->id . '\'); return false;"><span class="icon-remove" aria-hidden="true"></span>' . JText::_('JCLEAR').'</button>';
		}
		$html[] = '</span>';
		// class='required' for client side validation
		$class = '';
		if ($this->required) {
			$class = ' class="required modal-value"';
		}
		$html[] = '<input type="hidden" id="'.$this->id.'_id"'.$class.' name="'.$this->name.'" value="'.$value.'" />';
		return implode("\n", $html);
	}
}
?>
