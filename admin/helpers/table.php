<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Tools
* @copyright	Copyright (c) 2014 Norbert Kümin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

// No direct access
defined('_JEXEC') or die('Restricted access');
 
class TableHelper {
	public function updateCommonFieldsOnSave(&$table) {
		$date	= JFactory::getDate();
		$user	= JFactory::getUser();
		$db	= JFactory::getDbo();
		if (empty($table->id)) {
				$table->createddate = $date->toSql();
				$table->createdby = $user->get('name');
		}
		$table->modifieddate = $date->toSql();
		$table->modifiedby = $user->get('name');
	}
}
?>
