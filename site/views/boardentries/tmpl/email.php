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

defined('_JEXEC') or die; // no direct access

JLoader::register('EmailListHelper', JPATH_COMPONENT_ADMINISTRATOR.'/helpers/emaillist.php', true);

/*
 * Get parameters
 */
$boardPublicity = $this->paramsMenuEntry->get("boardpublicity");
$boardState = $this->paramsMenuEntry->get("boardstate");
$maxEmailAddr = $this->paramsMenuEntry->get("max_email_addr");
$targetField = $this->paramsMenuEntry->get("target_field");

/*
 * Get email addresses for members
 */
$cols = array();
$cols[] = "email";
$states = EmailListHelper::getStates($boardState);
$data = EmailListHelper::splitdata($this->items, $boardPublicity, 'board');
foreach($states as $state) {
	EmailListHelper::display_email_link(JText::_("COM_CLUBMANAGEMENT_BOARD")." (".JText::_($state)."):", $data[$state], $maxEmailAddr, $targetField);
}
?>

