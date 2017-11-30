<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Membership
* @copyright	Copyright (c) 2012 Norbert Kuemin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

JLoader::register('EmailListHelper', JPATH_COMPONENT_ADMINISTRATOR.'/helpers/emaillist.php', true);
JLoader::register('SelectionHelper', JPATH_COMPONENT_ADMINISTRATOR.'/helpers/selection.php', true);
function getMemberType($type, $memberTypes) {
	if (isset($memberTypes[$type]) && $memberTypes[$type]) {
		return $memberTypes[$type];
	}
	return $type;
}
// Get parameters
$memberType = $this->paramsMenuEntry->get("membertype");
$memberPublicity = $this->paramsMenuEntry->get("memberpublicity");
$memberState = $this->paramsMenuEntry->get("memberstate");
$maxEmailAddr = $this->paramsMenuEntry->get("max_email_addr");
$targetField = $this->paramsMenuEntry->get("target_field");
// Get email addresses for members
$cols = array();
$cols[] = "email";
$states = EmailListHelper::getStates($memberState);
if (!is_array($memberType)) {
	$temp = $memberType;
	$memberType = array();
	$memberType[0] = $temp;
}
reset($memberType);
$memberTypes = SelectionHelper::getSelection("member_types");
$data = EmailListHelper::splitdata($this->items, $memberPublicity,'member');
foreach($memberType as $type) {
	foreach($states as $state) {
		$key = $type.'_'.$state;
		if (isset($data[$key])) {
			EmailListHelper::display_email_link (getMemberType($type, $memberTypes)." (".JText::_($state)."):", $data[$key], $maxEmailAddr, $targetField);
		}
	}
}
?>
