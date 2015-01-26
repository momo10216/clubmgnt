<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.form.formfield');
jimport('joomla.application.component.helper');

class JFormFieldCmCustom extends JFormField
{
 
	protected $type = 'cmcustom';

	public function getLabel()
	{
		// Get the label text from the XML element, defaulting to the element name.
		$text = $this->element['label'] ? (string) $this->element['label'] : (string) $this->element['name'];

		// Build the class for the label.
		$class = !empty($this->description) ? 'hasTip' : '';
		$class = $this->required == true ? $class.' required' : $class;

		$label = '<label id="'.$this->id.'-lbl" for="'.$this->id.'" class="'.$class.'"';

		// If a description is specified, use it to build a tooltip.
		if (!empty($this->description)) {
			$label .= ' title="'.htmlspecialchars(trim(JText::_($text), ':').'::' .
				JText::_($this->description), ENT_COMPAT, 'UTF-8').'"';
		}

		// Retrive label
		$customLabel = JComponentHelper::getParams('com_clubmanagement')->get($this->element['name']);
		if (strlen($customLabel) == 0)
		{
			$customLabel = JText::_($this->element['label']);
		}

		// Add the label text and closing tag.
		$label .= '>'.$customLabel.'</label>';

		return $label; 
	}

	public function getInput()
	{
		// Initialize field attributes.
		$attr = ' type="text"';
		$attr .= ' name="'.$this->name.'"';
		$attr .= ' id="'.$this->id.'"';
		$attr .= ' value="'.htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8').'"';
		$attr .= $this->element['class'] ? ' class="' . (string) $this->element['class'] . '"' : '';
		$attr .= $this->element['size'] ? ' size="' . (int) $this->element['size'] . '"' : '';
		$attr .= $this->element['required'] ? ' required' : '';
		$attr .= $this->element['disabled'] ? ' disabled' : '';
		return ' <input'.$attr.' />';
	}

}
?>
