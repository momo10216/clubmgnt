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

$task = JRequest::getVar('task');
switch ($task) {
	case 'input':
		$this->loadTemplate('input');
		break;
	case 'create_pdf':
	default:
		$this->loadTemplate('output');
		break;
}
?>
