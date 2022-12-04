<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Board
* @copyright	Copyright (c) 2014 Norbert Kuemin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
 
// import Joomla table library
jimport('joomla.database.table');
 
class ClubManagementTableBoardEntry extends JTable {
    function __construct(&$db)  {
            parent::__construct('#__nokCM_board', 'id', $db);
    }

	public function check() {
		// Set fields to null if not set
		if (!$this->end) {
			$this->end = null;
		}
		return parent::check();
    }

	public function load($keys=null, $reset=true) {
	    if (parent::load($keys, $reset)) {
            if ($this->end == null) {
                $this->end = '';
            }
            return true;
	    }
        return false;
	}

	public function store($updateNulls = false) {
		// Transform the params field
		if (is_array($this->params)) {
			$registry = new JRegistry;
			$registry->loadArray($this->params);
			$this->params = (string) $registry;
		}
		JLoader::register('TableHelper', __DIR__.'/../helpers/table.php', true);
		TableHelper::updateCommonFieldsOnSave($this);
		return parent::store($updateNulls);
	}
}
?>
