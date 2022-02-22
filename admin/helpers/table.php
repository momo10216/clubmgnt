<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Tools
* @copyright	Copyright (c) 2014 Norbert Kuemin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
 
class TableHelper {
	public static function updateCommonFieldsOnSave(&$table) {
		$date	= JFactory::getDate();
		$user	= JFactory::getUser();
		$db	= JFactory::getDbo();
		$retval = array();

		if (empty($table->id)) {
				$retval['createddate'] = $date->toSql();
				$retval['createdby'] = $user->get('name');
		}
		$retval['modifieddate'] = $date->toSql();
		$retval['modifiedby'] = $user->get('name');
		return $retval;
	}
}
?>
