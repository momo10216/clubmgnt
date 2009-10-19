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
defined( '_JEXEC' ) or die( 'Restricted Access.' );

function com_uninstall() {
	// Get database handle
	$database =& JFactory::getDBO();

	// Create tables version 0.1
	$tables = array("#__nokCM_persons","#__nokCM_memberships","#__nokCM_board");
	foreach ($tables as $table) {
		$database->setQuery("DROP TABLE `" . $table . "`");
		$database->query();
	}
	return '<h1>Deinstallation successful!</h1>';
}
?>