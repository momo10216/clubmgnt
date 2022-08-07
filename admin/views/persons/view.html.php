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

use Joomla\CMS\Version;

/**
 * Persons View
 */
class ClubManagementViewPersons extends JViewLegacy {
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Persons view display method
	 * @return void
	 */
	function display($tpl = null)  {
        if (Version::MAJOR_VERSION == '3') {
    		ClubManagementHelper::addSubmenu('persons');
		}
		// Get data from the model
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$this->state = $this->get('State');
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		switch($this->getLayout()) {
			case "import":
				$this->addToolbarImport();
				break;
			default:
				$this->addToolbarList();
				break;
		}
		$this->sidebar = JHtmlSidebar::render();
		// Display the template
		parent::display($tpl);
	}

	protected function addToolbarList() {
		$canDo = JHelperContent::getActions('com_clubmanagement', 'category', $this->state->get('filter.category_id'));
		$user  = JFactory::getUser();
		// Get the toolbar object instance
		$bar = JToolBar::getInstance('toolbar');
		JToolbarHelper::title(JText::_('COM_CLUBMANAGEMENT_PERSONS_TITLE'), 'stack person');
		if ($canDo->get('core.create') || (count($user->getAuthorisedCategories('com_clubmanagement', 'core.create'))) > 0 ) {
			JToolbarHelper::addNew('person.add');
		}
		if (($canDo->get('core.edit')) || ($canDo->get('core.edit.own'))) {
			JToolbarHelper::editList('person.edit');
		}
		if ($this->state->get('filter.published') == -2 && $canDo->get('core.delete')) {
			JToolbarHelper::deleteList('', 'persons.delete', 'JTOOLBAR_EMPTY_TRASH');
		} elseif ($canDo->get('core.edit.state')) {
			JToolbarHelper::trash('persons.delete');
		}
		// Add a export button
		JToolBarHelper::custom('persons.export', 'export.png', 'export_f2.png', JText::_('JTOOLBAR_EXPORT'), false);
		// Add a import button
		if ($user->authorise('core.create', 'com_clubmanagement')) {
			JToolBarHelper::custom('persons.import', 'import.png', 'import_f2.png', JText::_('JTOOLBAR_IMPORT'), false);
		}
		if ($user->authorise('core.admin', 'com_clubmanagement')) {
			JToolbarHelper::preferences('com_clubmanagement');
		}
		//JToolbarHelper::help('JHELP_CONTENT_ARTICLE_MANAGER');
	}

	protected function addToolbarImport() {
		// Get the toolbar object instance
		$bar = JToolBar::getInstance('toolbar');
		JToolbarHelper::title(JText::_('COM_CLUBMANAGEMENT_PERSONS_TITLE'), 'stack person');
		JToolBarHelper::custom('persons.import_cancel', 'cancel.png', 'cancel_f2.png', JText::_('JTOOLBAR_CLOSE'), false);
	}

	/**
	 * Returns an array of fields the table can be sorted by
	 *
	 * @return  array  Array containing the field name to sort by as the key and display text as value
	 *
	 * @since   3.0
	 */
	protected function getSortFields() {
		return array (
			'p.name,p.firstname' => JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_FULLNAME_LABEL'),
			'p.name' => JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_NAME_LABEL'),
			'p.firstname' => JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_FIRSTNAME_LABEL'),
			'p.address' => JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_ADDRESS_LABEL'),
			'p.zip' => JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_ZIP_LABEL'),
			'p.city' => JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_CITY_LABEL'),
			'p.state' => JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_STATE_LABEL'),
			'p.country' => JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_COUNTRY_LABEL')
		);
	}
}
?>