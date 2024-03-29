<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Person
* @copyright	Copyright (c) 2012 Norbert Kuemin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Language\Text;
use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;

function showError($msg) {
	echo $msg;
}

if ($this->paramsMenuEntry->get('allow_edit') == '0') {
	// Not allowed to edit
    showError(Text::_('COM_CLUBMANAGEMENT_ERROR_PERSON_EDIT_NOT_ALLOWED'));
	return;
}
$task = JFactory::getApplication()->input->getString('task');
switch ($task) {
	case 'save':
		echo $this->loadTemplate('save');
		break;
	case 'cancel':
        showError(Text::_('COM_CLUBMANAGEMENT_DATA_NOT_SAVED'));
		break;
	case 'edit':
	default:
        $uri = Uri::getInstance();
		$id = $uri->getVar('id');
		if (!$id) {
		    $id = JFactory::getApplication()->input->getString('id');
		}
		if (!$id) {
			$id_list = $this->getModel()->getPersonIdListForCurrentUser();
		} else {
			$id_list = array($id);
		}
		if (count($this->idList) < 1) {
            showError(Text::_('COM_CLUBMANAGEMENT_ERROR_PERSON_EDIT_NO_RECORD'));
		}
		if (count($this->idList) == 1) echo $this->loadTemplate('edit');
		if (count($this->idList) > 1) echo $this->loadTemplate('list');
		break;
}
?>
