<?php
/**
* @version		2.5.0
* @package		Joomla
* @subpackage	ClubManagement-Main
* @copyright	Copyright (c) 2012 Norbert Kümin. All rights reserved.
* @license		http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author		Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// Common Functions
function nokCM_error ($text, $back=true) {
	echo "<script> alert('" . addslashes($text) . "'); ";
	if ($back) echo "window.history.go(-1); ";
	echo "</script>\n";
	//echo "ERROR: " . $text;
}

require_once(JPATH_COMPONENT.DS.'controller.php');

// Create the controller
$controller = new clubmanagementController();

// Perform the Request task
$controller->execute(JRequest::getVar('task', null, 'default', 'cmd'));
$controller->redirect();
