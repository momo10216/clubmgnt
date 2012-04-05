<?php
/**
* @version	2.5
* @package	Joomla
* @subpackage	ClubManagement-Main
* @copyright	Copyright (c) 2009 Norbert Kümin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/
defined( '_JEXEC' ) or die( 'Restricted Access.' );

// Include object related functions
require_once( dirname(__FILE__).DS.'classes'.DS.'nokCMPerson.php');
require_once( dirname(__FILE__).DS.'classes'.DS.'nokCMMembership.php');
require_once( dirname(__FILE__).DS.'classes'.DS.'nokCMBoard.php');

function com_install() {
	// Init
	$objPerson = new nokCMPerson();
	$objMember = new nokCMMembership();
	$objBoard = new nokCMBoard();

	$objPerson->install();
	$objMember->install();
	$objBoard->install();

	// Show installation result to user
	return '<h1>Installation successful!</h1>';
}
?>
