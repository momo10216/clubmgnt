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
		if ($table->id) {
			// Existing item
			$table->modifieddate = $db->quote($date->toSql());
			$table->modifiedby = $db->quote($user->get('id'));
		} else {
			// New person. A person created and created_by field can be set by the user,
			// so we don't touch either of these if they are set.
			if (!(int) $table->created) {
				$table->createddate = $db->quote($date->toSql());
			}
			if (empty($table->created_by)) {
				$table->createdby = $db->quote($user->get('id'));
			}
		}
	}
}
?>
