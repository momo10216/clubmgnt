<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Membership
* @copyright	Copyright (c) 2012 Norbert Kümin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

defined('JPATH_BASE') or die;

require_once( dirname(__FILE__).DS.'..'.DS.'classes'.DS.'nokCMPerson.php');

/**
 * Supports a modal person picker.
 *
 * @package	Joomla.Administrator
 * @subpackage	com_clubmanagement
 * @since	1.6
 */
class JFormFieldCMPersonRecord extends JFormField {
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'CMPersonRecord';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	protected function getInput() {

		$cmobject = new nokCMPerson('com_clubmanagement');
		$doc =& JFactory::getDocument();

		$title		= "";
		if ($this->value) {
			$row = $cmobject->get($this->value,$cmobject->column_list);
			$title = implode($row, " ");
		}

		// Build the script.
		$script = array();
		$script[] = '	function jSelectRecord_'.$this->id.'(id, name) {';
		$script[] = '		document.id("'.$this->id.'_id").value = id;';
		$script[] = '		document.id("'.$this->id.'_name").value = name;';
		$script[] = '		SqueezeBox.close();';
		$script[] = '	}';

		// Add the script to the document head.
		$doc->addScriptDeclaration(implode("\n", $script));

		// Build the script.
		$script = array();
		$script[] = '	window.addEvent("domready", function() {';
		$script[] = '		var div = new Element("div").setStyle("display", "none").inject(document.id("menu-types"), "before");';
		$script[] = '		document.id("menu-types").inject(div, "bottom");';
		$script[] = '	});';

		// Add the script to the document head.
		$doc->addScriptDeclaration(implode("\n", $script));

		$link = 'index.php?option=com_clubmanagement&layout=modal&amp;task=select&amp;cmobj=person&amp;tmpl=component&amp;&amp;function=jSelectRecord_'.$this->id;

		JHTML::_('behavior.modal', 'a.modal');
		$html = "\n".'<div style="float: left;"><input style="background: #ffffff;" type="text" id="'.$this->id.'_name" value="'.htmlspecialchars($title, ENT_QUOTES, 'UTF-8').'" disabled="disabled" /></div>';
		$html .= '<div class="button2-left"><div class="blank"><a class="modal" title="'.$title.'"  href="'.$link.'" rel="{handler: \'iframe\', size: {x: 650, y: 375}}">'.JText::_('SELECT').'</a></div></div>'."\n";
		$html .= "\n".'<input type="hidden" id="'.$this->id.'_id" name="'.$this->name.'" value="'.$value.'" />';

		return $html;
	}
}
