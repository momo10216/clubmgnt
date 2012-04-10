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
defined('_JEXEC') or die;

// Common Functions
function nokCM_error ($text, $back=true) {
	echo "<script> alert('" . addslashes($text) . "'); ";
	if ($back) echo "window.history.go(-1); ";
	echo "</script>\n";
	//echo "ERROR: " . $text;
}

jimport('joomla.application.component.controller');
//require_once JPATH_COMPONENT.'/helpers/route.php';

$controller = JController::getInstance('Clubmanagement');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();
?>

