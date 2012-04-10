<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Main
* @copyright	Copyright (c) 2012 Norbert Kümin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Common Functions
function nokCM_error ($text, $back=true) {
	echo "<script> alert('" . addslashes($text) . "'); ";
	if ($back) echo "window.history.go(-1); ";
	echo "</script>\n";
	//echo "ERROR: " . $text;
}

// Include object related functions
require_once( dirname(__FILE__).DS.'classes'.DS.'nokCMPerson.php');
require_once( dirname(__FILE__).DS.'classes'.DS.'nokCMMembership.php');
require_once( dirname(__FILE__).DS.'classes'.DS.'nokCMBoard.php');

// Submenus
JSubMenuHelper::addEntry(JText::_('SUBMENU_CLUBMANAGEMENT_PERSON'), 'index.php?option=com_clubmanagement&amp;amp;cmobj=person&amp;amp;task=list');
JSubMenuHelper::addEntry(JText::_('SUBMENU_CLUBMANAGEMENT_MEMBERSHIP'), 'index.php?option=com_clubmanagement&amp;amp;cmobj=membership&amp;amp;task=list');
JSubMenuHelper::addEntry(JText::_('SUBMENU_CLUBMANAGEMENT_BOARD'), 'index.php?option=com_clubmanagement&amp;amp;cmobj=board&amp;amp;task=list');

// Main
$component = "com_clubmanagement";
$cmd = JRequest::getCmd('task');
$object = JRequest::getCmd('cmobj');
$doc = JFactory::getDocument();
$doc->setTitle( JText::_("CLUB_MANAGEMENT") );
switch ($object) {
	case 'person':
		$cmobject = new nokCMPerson($component);
		$cmobject->menu( $cmd, $option );
		break;
	case 'membership':
		$cmobject = new nokCMMembership($component);
		$cmobject->menu( $cmd, $option );
		break;
	case 'board':
		$cmobject = new nokCMBoard($component);
		$cmobject->menu( $cmd, $option );
		break;
	case '':
		break;
	default:
		nokCM_error(JText::sprintf( 'ERROR_UNKNOWN_OBJECT', $object));
		break;
}
?>
