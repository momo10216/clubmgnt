<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Membership
* @copyright	Copyright (c) 2012 Norbert KUEmin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Version;
use Joomla\CMS\Language\Text;

JLoader::register('EmailListHelper', JPATH_COMPONENT_ADMINISTRATOR.'/helpers/emaillist.php', true);

/*
 * Get parameters
 */
$boardPublicity = $this->paramsMenuEntry->get("boardpublicity");
$boardState = $this->paramsMenuEntry->get("boardstate");
$maxEmailAddr = $this->paramsMenuEntry->get("max_email_addr");
$targetField = $this->paramsMenuEntry->get("target_field");

/*
 * Get email addresses for members
 */
$cols = array();
$cols[] = "email";
$states = EmailListHelper::getStates($boardState);
$data = EmailListHelper::splitdata($this->items, $boardPublicity, 'board');
// Display
if (!empty($this->paramsMenuEntry->get('pretext'))) { echo $this->paramsMenuEntry->get('pretext'); }
foreach($states as $state) {
	if (isset($data[$state])) {
        if (Version::MAJOR_VERSION == '3') {
    		EmailListHelper::display_email_link(JText::_("COM_CLUBMANAGEMENT_BOARD")." (".JText::_($boardState)."):", $data[$state], $maxEmailAddr, $targetField);
        } elseif (Version::MAJOR_VERSION == '4') {
    		EmailListHelper::display_email_link(Text::_("COM_CLUBMANAGEMENT_BOARD")." (".Text::_($boardState)."):", $data[$state], $maxEmailAddr, $targetField);
        }
	}
}
if (!empty($this->paramsMenuEntry->get('posttext'))) { echo $this->paramsMenuEntry->get('posttext'); }
?>

