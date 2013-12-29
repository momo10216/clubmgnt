<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Membership
* @copyright	Copyright (c) 2012 Norbert Kümin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die;

jimport( 'joomla.application.component.view' );
require_once( JPATH_COMPONENT_ADMINISTRATOR.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'nokCMMembership.php');

class ClubmanagementViewmember extends JView {
	var $user;
	var $document;
	var $params;
	var $params_menu;
	var $header;
	var $data;
	var $menu;
	var $cmobject;

	function display($tpl = null) {
		/*
		 * Init variables
		 */
		$this->user =& JFactory::getUser();
		$this->document =& JFactory::getDocument();
		$this->params =& JComponentHelper::getParams( 'com_clubmanagement' );
		$menus = &JSite::getMenu();
		$this->menu = $menus->getActive();
		$this->cmobject = new nokCMMembership("com_clubmanagement");
		if (is_object( $this->menu )) {
			$this->params_menu = $this->menu->params;
		}

		/*
		 * Init document
		 */
		$this->document->setMetaData('robots', 'noindex, nofollow');
		parent::display($tpl);
    }
}
?>
