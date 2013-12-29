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
defined( '_JEXEC' ) or die;

// Include object related functions
require_once( dirname(__FILE__).DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'nokCMPerson.php');
require_once( dirname(__FILE__).DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'nokCMMembership.php');
require_once( dirname(__FILE__).DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'nokCMBoard.php');

class com_componentnameInstallerScript
{
        /**
         * Constructor
         *
         * @param   JAdapterInstance  $adapter  The object responsible for running this script
         */
        public function __construct(JAdapterInstance $adapter);
 
        /**
         * Called before any type of action
         *
         * @param   string  $route  Which action is happening (install|uninstall|discover_install|update)
         * @param   JAdapterInstance  $adapter  The object responsible for running this script
         *
         * @return  boolean  True on success
         */
        public function preflight($route, JAdapterInstance $adapter);
 
        /**
         * Called after any type of action
         *
         * @param   string  $route  Which action is happening (install|uninstall|discover_install|update)
         * @param   JAdapterInstance  $adapter  The object responsible for running this script
         *
         * @return  boolean  True on success
         */
        public function postflight($route, JAdapterInstance $adapter);
 
        /**
         * Called on installation
         *
         * @param   JAdapterInstance  $adapter  The object responsible for running this script
         *
         * @return  boolean  True on success
         */
        public function install(JAdapterInstance $adapter) {
		$component = "com_clubmanagement";
		$objPerson = new nokCMPerson($component);
		$objMember = new nokCMMembership($component);
		$objBoard = new nokCMBoard($component);

		$objPerson->install();
		$objMember->install();
		$objBoard->install();
	}
 
        /**
         * Called on update
         *
         * @param   JAdapterInstance  $adapter  The object responsible for running this script
         *
         * @return  boolean  True on success
         */
        public function update(JAdapterInstance $adapter) {
		$this->install($adapter);
	}
 
        /**
         * Called on uninstallation
         *
         * @param   JAdapterInstance  $adapter  The object responsible for running this script
         */
        public function uninstall(JAdapterInstance $adapter) {
		$component = "com_clubmanagement";
		$objPerson = new nokCMPerson($component);
		$objMember = new nokCMMembership($component);
		$objBoard = new nokCMBoard($component);

		$objPerson->uninstall();
		$objMember->uninstall();
		$objBoard->uninstall();
	}
}

?>
