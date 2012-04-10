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
 * Supports a modal newsfeeds picker.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_newsfeeds
 * @since		1.6
 */
class JFormFieldPersonRecord extends JFormField {
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'PersonRecord';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	protected function getInput() {
		global $mainframe;

		$cmobject	= new nokCMPerson("com_clubmanagement");
		$db		=& JFactory::getDBO();
		$doc 		=& JFactory::getDocument();
		$title		= JText::_('SELECT_PERSON');

		$js = "
		function jSelectRecord(id, title, object) {
			document.getElementById(object + '_id').value = id;
			document.getElementById(object + '_name').value = title;
			document.getElementById('sbox-window').close();
		}";
		$doc->addScriptDeclaration($js);

		$link = 'index.php?option=com_clubmanagement&amp;task=select&amp;cmobj=person&amp;tmpl=component&amp;object='.$this->id;

		JHTML::_('behavior.modal', 'a.modal');
		$html = "\n".'<div style="float: left;"><input style="background: #ffffff;" type="text" id="'.$this->id.'_name" value="'.htmlspecialchars($title, ENT_QUOTES, 'UTF-8').'" disabled="disabled" /></div>';
		$html .= '<div class="button2-left"><div class="blank"><a class="modal" title="'.$title.'"  href="'.$link.'" rel="{handler: \'iframe\', size: {x: 650, y: 375}}">'.JText::_('SELECT').'</a></div></div>'."\n";
		$html .= "\n".'<input type="hidden" id="'.$this->id.'_id" name="'.$this->name.'" value="'.$value.'" />';

		return $html;
	}
}
