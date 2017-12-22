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

function showError($msg) {
	echo $msg;
}

$task = JRequest::getVar('task');
switch ($task) {
	case 'input':
		echo $this->loadTemplate('save');
		break;
	case 'create_pdf':
	default:
		$uri = JFactory::getURI();
		$id = $uri->getVar('id');
		if (!$id) $id = JRequest::getVar('id');
		if (!$id) {
			$id_list = $this->getModel()->getPersonIdListForCurrentUser();
		} else {
			$id_list = array($id);
		}
		if (count($this->idList) < 1) showError(JText::_('COM_CLUBMANAGEMENT_ERROR_PERSON_EDIT_NO_RECORD'));
		if (count($this->idList) == 1) echo $this->loadTemplate('edit');
		if (count($this->idList) > 1) echo $this->loadTemplate('list');
		break;
}
?>
