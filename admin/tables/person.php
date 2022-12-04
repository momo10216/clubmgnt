<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Person
* @copyright	Copyright (c) 2014 Norbert Kuemin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
 
// import Joomla table library
jimport('joomla.database.table');
 
class ClubManagementTablePerson extends JTable {
    function __construct(&$db)  {
        parent::__construct('#__nokCM_persons', 'id', $db);
    }

	public function check() {
		// Set fields to null if not set
		if (!$this->birthday) {
			$this->birthday = null;
		}
		if (!$this->deceased) {
			$this->deceased = null;
		}
		if (!$this->user_id) {
			$this->user_id = null;
		}
		if (!$this->hh_person_id) {
			$this->hh_person_id = null;
		}
		return parent::check();
    }

	public function load($keys=null, $reset=true) {
	    if (parent::load($keys, $reset)) {
            if ($this->birthday == null) {
                $this->birthday = '';
            }
            if ($this->deceased == null) {
                $this->deceased = '';
            }
            return true;
	    }
        return false;
	}

	public function store($updateNulls = true) {
		// Transform the params field
		if (is_array($this->params)) {
			$registry = new JRegistry;
			$registry->loadArray($this->params);
			$this->params = (string) $registry;
		}
		JLoader::register('TableHelper', __DIR__.'/../helpers/table.php', true);
		TableHelper::updateCommonFieldsOnSave($this);
		// Store utf8 email as punycode
		$this->email = JStringPunycode::emailToPunycode($this->email);
		// Convert IDN urls to punycode
		$this->url = JStringPunycode::urlToPunycode($this->url);
		return parent::store($updateNulls);
	}
}
?>
