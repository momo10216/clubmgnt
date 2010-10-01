<?php
/**
* @version		0.92
* @package		Joomla
* @subpackage	ClubManagement-Membership
* @copyright	Copyright (c) 2009 Norbert Kümin. All rights reserved.
* @license		http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author		Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/


// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

require_once( dirname(__FILE__).DS.'..'.DS.'classes'.DS.'nokCMMembership.php');

class JElementCMMemberType extends JElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'CMMemberType';

	function fetchElement($name, $value, &$node, $control_name)
	{
		$cmobject = new nokCMMembership("com_clubmanagement");
		$arrList = $cmobject->getMemberTypes();
		$opt[] = JHTML::_("select.option",  "*", JText::_("ALL"));
		$ctrl = $control_name.'['.$name.']';
		$multi = false;

		// Construct the various argument calls that are supported.
		$attribs = '';
		if ($v = $node->attributes( 'size' )) {
				$attribs .= 'size="'.$v.'" ';
		}
		if ($v = $node->attributes( 'class' )) {
				$attribs       .= 'class="'.$v.'" ';
		} else {
				$attribs       .= 'class="inputbox" ';
		}
		if (($v = $node->attributes( 'multiple' )) && ($v == "true")) {
			$attribs .= 'multiple ';
			$ctrl .= '[]';
			$multi = true;
		}

		reset($arrList);
		while (list($strValue,$strDisplay) = each($arrList)) {
			if (($multi === true) && ($strValue == "*")) {
				// Don't add ALL to multi select list
			} else {
				$opt[] = JHTML::_("select.option",  $strValue, $strDisplay);
			}
		}
		return JHTML::_('select.genericlist', $opt, $ctrl, $attribs, "value", "text", $value);
	}
}