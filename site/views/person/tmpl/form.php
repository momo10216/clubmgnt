<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Person
* @copyright	Copyright (c) 2012 Norbert Kümin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/
defined('_JEXEC') or die; // no direct access
function showError($msg) {
	echo $msg;
}
if ($this->paramsMenuEntry->get('allow_edit') == '0') {
	// Not allowed to edit
	showError(JText::_('COM_CLUBMANAGEMENT_ERROR_PERSON_EDIT_NOT_ALLOWED'));
	return;
}
$task = JRequest::getVar('task');
switch ($task) {
	case 'save':
		echo $this->loadTemplate('save');
		break;
	case 'cancel':
		showError(JText::_('COM_CLUBMANAGEMENT_DATA_NOT_SAVED'));
		break;
	case 'edit':
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
