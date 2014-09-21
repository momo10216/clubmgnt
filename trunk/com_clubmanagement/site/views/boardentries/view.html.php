<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Board
* @copyright	Copyright (c) 2012 Norbert Kümin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

defined('_JEXEC') or die;

class ClubManagementViewBoardentries extends JViewLegacy
{
	protected $items;
	protected $pageHeading = 'COM_CLUBMANAGEMENT_PAGE_TITLE_DEFAULT';
	protected $paramsComponent;
	protected $paramsMenuEntry;
	protected $user;

	function display($tpl = null) {
		/*
		 * Init variables
		 */
		$this->user =& JFactory::getUser();
		$app = JFactory::getApplication();
		$this->items = $this->get('Items');
		$this->state = $this->get('State');
		$this->paramsComponent = $this->state->get('params');
		$currentMenu = $app->getMenu()->getActive();
		if (is_object( $currentMenu )) {
			$this->paramsMenuEntry = $currentMenu->params;
		}

		/*
		 * Init document
		 */
		JFactory::getDocument()->setMetaData('robots', 'noindex, nofollow');
		parent::display($tpl);
    }
}
