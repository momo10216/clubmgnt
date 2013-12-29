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
defined( '_JEXEC' ) or die( 'Restricted Access.' );

// Include object related functions
require_once( dirname(__FILE__).DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'nokCMPerson.php');
require_once( dirname(__FILE__).DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'nokCMMembership.php');
require_once( dirname(__FILE__).DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'nokCMBoard.php');

function com_uninstall() {
	// Init
	$component = "com_clubmanagement";
	$objPerson = new nokCMPerson($component);
	$objMember = new nokCMMembership($component);
	$objBoard = new nokCMBoard($component);

	$objPerson->uninstall();
	$objMember->uninstall();
	$objBoard->uninstall();

	return '<h1>Deinstallation successful!</h1>';
}
?>
