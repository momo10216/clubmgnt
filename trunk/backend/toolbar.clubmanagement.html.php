<?php
/**
* @version		0.5
* @package		Joomla
* @subpackage	ClubManagement-Main
* @copyright	Copyright (c) 2009 Norbert K�min. All rights reserved.
* @license		http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author		Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
* @package		Joomla
* @subpackage	clubmanagement
*/

// Include object related functions
require_once( dirname(__FILE__).DS.'classes'.DS.'nokCMPerson.php');
require_once( dirname(__FILE__).DS.'classes'.DS.'nokCMMembership.php');
require_once( dirname(__FILE__).DS.'classes'.DS.'nokCMBoard.php');
require_once( dirname(__FILE__).DS.'classes'.DS.'nokCMReport.php');

JHTML::_('stylesheet', 'icon.css', 'administrator/components/com_clubmanagement/css/');

class TOOLBAR_clubmanagement
{
	function _DEFAULT()
	{
		$object = JRequest::getCmd('cmobj');
		switch ($object) {
			case 'person':
				$cmobject = new nokCMPerson($component);
				break;
			case 'membership':
				$cmobject = new nokCMMembership($component);
				break;
			case 'board':
				$cmobject = new nokCMBoard($component);
				break;
			default:
				break;
		}
		JToolBarHelper::title(  JText::_( 'Club Management' ) );
		if ($cmobject) {
			if ($cmobject->isToolbarEntrySet("publish")) JToolBarHelper::publishList();
			if ($cmobject->isToolbarEntrySet("unpublish")) JToolBarHelper::unpublishList();
			if ($cmobject->isToolbarEntrySet("delete")) JToolBarHelper::deleteList();
			if ($cmobject->isToolbarEntrySet("edit")) JToolBarHelper::editListX();
			if ($cmobject->isToolbarEntrySet("add")) JToolBarHelper::addNewX();
			if ($cmobject->isToolbarEntrySet("export")) JToolBarHelper::customX('export', 'export', 'export', JText::_('Export'), false); 
			if ($cmobject->isToolbarEntrySet("import")) JToolBarHelper::customX('import', 'import', 'import', JText::_('Import'), false); 
			if ($cmobject->isToolbarEntrySet("preferences")) JToolBarHelper::preferences('com_clubmanagement');
			if ($cmobject->isToolbarEntrySet("help")) JToolBarHelper::help( 'screen.clubmanagement' );
		} else {
//			JToolBarHelper::publishList();
//			JToolBarHelper::unpublishList();
			JToolBarHelper::deleteList();
			JToolBarHelper::editListX();
			JToolBarHelper::addNewX();
			JToolBarHelper::customX('export', 'export', 'export', JText::_('Export'), false); 
			JToolBarHelper::customX('import', 'import', 'import', JText::_('Import'), false); 
			JToolBarHelper::preferences('com_clubmanagement');
			JToolBarHelper::help( 'screen.clubmanagement' );
		}
	}

	function _EDIT($edit)
	{
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		JArrayHelper::toInteger($cid, array(0));

		$text 	= ( $edit ? JText::_( 'Edit' ) : JText::_( 'New' ) );

		JToolBarHelper::title(  JText::_( 'Club management' ).': <small><small>[ '. $text.' ]</small></small>' );
		JToolBarHelper::save();
		JToolBarHelper::apply();
		if ($edit) {
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );
		} else {
			JToolBarHelper::cancel();
		}
		JToolBarHelper::help( 'screen.clubmanagement.edit' );
	}
}