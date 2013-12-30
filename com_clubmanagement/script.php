<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Main
* @copyright	Copyright (c) 2013 Norbert Kümin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/
defined('_JEXEC') or die ('Restricted access');

$cmAdminClassPath = JPATH_ADMINISTRATOR.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_clubmanagement'.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR;
if (!file_exists($cmAdminClassPath.'nokCMPerson.php')) {
	//Fresh installation take package path
	$cmAdminClassPath = dirname(__FILE__).DIRECTORY_SEPARATOR.'backend'.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR;
}
require_once($cmAdminClassPath.'nokCMPerson.php');
require_once($cmAdminClassPath.'nokCMMembership.php');
require_once($cmAdminClassPath.'nokCMBoard.php');

class com_clubmanagementInstallerScript
{
	private $bDebugOn = false;
	private $objPerson;
	private $objMember;
	private $objBoard;

        /**
         * Called before any type of action
         *
         * @param   string  $route  Which action is happening (install|uninstall|discover_install|update)
         * @param   JAdapterInstance  $adapter  The object responsible for running this script
         *
         * @return  boolean  True on success
         */
        public function preflight($route, JAdapterInstance $adapter) {
		$this->debug("Event: Preflight");
		$component = "";
		$this->objPerson = new nokCMPerson($component);
		$this->objMember = new nokCMMembership($component);
		$this->objBoard = new nokCMBoard($component);
		return true;
	}
 
        /**
         * Called after any type of action
         *
         * @param   string  $route  Which action is happening (install|uninstall|discover_install|update)
         * @param   JAdapterInstance  $adapter  The object responsible for running this script
         *
         * @return  boolean  True on success
         */
        public function postflight($route, JAdapterInstance $adapter) {
		$this->debug("Event: Postflight");
		return true;
	}
 
        /**
         * Called on installation
         *
         * @param   JAdapterInstance  $adapter  The object responsible for running this script
         *
         * @return  boolean  True on success
         */
        public function install(JAdapterInstance $adapter) {
		$this->debug("Event: Installation");
		return $this->installOrUpdate();
	}
 
        /**
         * Called on update
         *
         * @param   JAdapterInstance  $adapter  The object responsible for running this script
         *
         * @return  boolean  True on success
         */
        public function update(JAdapterInstance $adapter) {
		$this->debug("Event: Update");
		return $this->installOrUpdate();
	}
 
        /**
         * Called on uninstallation
         *
         * @param   JAdapterInstance  $adapter  The object responsible for running this script
         */
        public function uninstall(JAdapterInstance $adapter) {
		// WORKAROUND: Joomla does not trigger the preflight method for uninstall. Do it manually.
		$statusOk = $this->preflight("uninstall",$adapter);
		$this->debug("Event: Uninstall");
		if ($statusOk === true) {
			$statusOk = $this->objBoard->uninstall();
		}
		if ($statusOk === true) {
			$statusOk = $this->objMember->uninstall();
		}
		if ($statusOk === true) {
			$statusOk = $this->objPerson->uninstall();
		}
		// WORKAROUND: Joomla does not trigger the postflight method for uninstall. Do it manually.
		if ($statusOk === true) {
			$statusOk = $this->postflight("uninstall",$adapter);
		}
		return $statusOk;
	}

	private function debug ($message) {
		if ($this->bDebugOn) {
			echo "<p><b>".$message."!</b></p>";
		}
	}

	private function installOrUpdate() {
		$statusOk = true;
		if ($statusOk) {
			$statusOk = $this->objPerson->install();
		}
		if ($statusOk) {
			$statusOk = $this->objMember->install();
		}
		if ($statusOk) {
			$statusOk = $this->objBoard->install();
		}
		return $statusOk;
	}
}

?>
