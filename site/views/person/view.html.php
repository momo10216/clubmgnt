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

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Version;
use Joomla\CMS\Language\Text;

class ClubManagementViewPerson extends JViewLegacy {
	protected $item;
	protected $pageHeading = 'COM_CLUBMANAGEMENT_PAGE_TITLE_DEFAULT';
	protected $paramsComponent;
	protected $paramsMenuEntry;
	protected $user;
	protected $iframe;
	protected $idList = array();

	function display($tpl = null) {
		// Init variables
		$this->state = $this->get('State');
		if ($this->getLayout() =='form') {
			$this->getModel()->setUseAlias(false);
		}
		$this->user = JFactory::getUser();
		$app = JFactory::getApplication();
		$this->document = JFactory::getDocument();
		$this->paramsComponent = $this->state->get('params');
		$menu = $app->getMenu();
		if (is_object($menu)) {
			$currentMenu = $menu->getActive();
			if (is_object($currentMenu)) {
				$this->paramsMenuEntry = $currentMenu->getParams();
			}
		}
		$id = JFactory::getApplication()->input->getString('id');
		if (!$id) { $id = $this->state->get('person.id'); }
		if (!$id) {
			$this->idList = $this->getModel()->getPersonIdListForCurrentUser();
		} else {
			$this->idList = array($id);
		}
		if (count($this->idList) == 1) {
			$this->getModel()->setPk($this->idList[0]);
		}
		$this->item = $this->get('Item');
		$this->form = $this->get('Form');
		$this->iframe = JFactory::getApplication()->input->getString('iframe');
		if ($this->iframe != '1') $this->iframe = '0';
		// Init document
		JFactory::getDocument()->setMetaData('robots', 'noindex, nofollow');
		parent::display($tpl);
	}
}
?>
