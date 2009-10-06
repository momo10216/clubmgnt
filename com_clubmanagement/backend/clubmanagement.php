<?php
/**
* @version		0.5
* @package		Joomla
* @subpackage	ClubManagement-Main
* @copyright	Copyright (c) 2009 Norbert Kümin. All rights reserved.
* @license		http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author		Norbert Kuemin
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
require_once( dirname(__FILE__).DS.'classes'.DS.'nokCMReport.php');

// Main
$component = "com_clubmanagement";
$cmd = JRequest::getCmd('task');
$object = JRequest::getCmd('cmobj');
$mainframe->setPageTitle( JText::_("Club Management") );
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
	case 'report':
		$cmobject = new nokCMReport($component);
		$cmobject->menu( $cmd, $option );
		break;
	case '':
		break;
	default:
		nokCM_error(JText::sprintf( 'ERROR_UNKNOWN_OBJECT', $object));
		break;
}
?>