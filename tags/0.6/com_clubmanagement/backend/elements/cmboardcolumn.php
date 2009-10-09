<?php
/**
* @version		0.5
* @package		Joomla
* @subpackage	ClubManagement-Board
* @copyright	Copyright (c) 2009 Norbert Kümin. All rights reserved.
* @license		http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author		Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

require_once( dirname(__FILE__).DS.'..'.DS.'classes'.DS.'nokCMBoard.php');

class JElementCMBoardColumn extends JElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'CMMemberColumn';

	function fetchElement($name, $value, &$node, $control_name)
	{
		$cmobject = new nokCMBoard("com_clubmanagement");
		$arrList = $cmobject->getColumns("view");
		$opt[] = JHTML::_("select.option",  "", "<none>");
		$ctrl = $control_name.'['.$name.']';

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
		if (($m = $node->attributes( 'multiple' )) && ($m == "true"))
		{
				$attribs       .= 'multiple ';
				$ctrl          .= '[]';
		}
		if ($m = $node->attributes( 'columntype' ))
		{
			$arrList = $cmobject->getColumns($m);
		}
		else
		{
			$arrList = $cmobject->getColumns("view");
		}

		reset($arrList);
		while (list($strValue,$strDisplay) = each($arrList)) {
			$opt[] = JHTML::_("select.option",  $strValue, $strDisplay);
		}
		return JHTML::_('select.genericlist',   $opt, $ctrl, $attribs, "value", "text", $value);
	}
}