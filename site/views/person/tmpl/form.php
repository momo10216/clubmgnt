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

use Joomla\CMS\Version;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;

function showError($msg) {
	echo $msg;
}

function translate($key) {
    if (Version::MAJOR_VERSION == '3') {
        return JText::_($key);
    } elseif (Version::MAJOR_VERSION == '4') {
        return Text::_($key);
    }
    return $key;
}

if ($this->paramsMenuEntry->get('allow_edit') == '0') {
	// Not allowed to edit
    showError(translate('COM_CLUBMANAGEMENT_ERROR_PERSON_EDIT_NOT_ALLOWED'));
	return;
}
$task = JFactory::getApplication()->input->getString('task');
switch ($task) {
	case 'save':
		echo $this->loadTemplate('save');
		break;
	case 'cancel':
        showError(translate('COM_CLUBMANAGEMENT_DATA_NOT_SAVED'));
		break;
	case 'edit':
	default:
        if (Version::MAJOR_VERSION == '3') {
            $curi = JFactory::getURI();
            $uri = JURI::getInstance( $curi->toString() );
        } else {
            $uri = Uri::getInstance();
        }
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
            showError(translate('COM_CLUBMANAGEMENT_ERROR_PERSON_EDIT_NO_RECORD'));
		}
		if (count($this->idList) == 1) echo $this->loadTemplate('edit');
		if (count($this->idList) > 1) echo $this->loadTemplate('list');
		break;
}
?>
