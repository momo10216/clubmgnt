<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Member
* @copyright	Copyright (c) 2014 Norbert Kümin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
/**
 * Memberships View
 */
class ClubManagementViewMemberships extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Persons view display method
	 * @return void
	 */

	function display($tpl = null) 
	{
		ClubManagementHelper::addSidebar('memberships');

		// Get data from the model
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$this->state = $this->get('State');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
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

	protected function addToolbarList()
	{
		$canDo = JHelperContent::getActions('com_clubmanagement', 'category', $this->state->get('filter.category_id'));
		$user  = JFactory::getUser();

		// Get the toolbar object instance
		$bar = JToolBar::getInstance('toolbar');

		JToolbarHelper::title(JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_TITLE'), 'stack person');

		if ($canDo->get('core.create') || (count($user->getAuthorisedCategories('com_clubmanagement', 'core.create'))) > 0 )
		{
			JToolbarHelper::addNew('membership.add');
		}

		if (($canDo->get('core.edit')) || ($canDo->get('core.edit.own')))
		{
			JToolbarHelper::editList('membership.edit');
		}

		if ($this->state->get('filter.published') == -2 && $canDo->get('core.delete'))
		{
			JToolbarHelper::deleteList('', 'memberships.delete', 'JTOOLBAR_EMPTY_TRASH');
		}
		elseif ($canDo->get('core.edit.state'))
		{
			JToolbarHelper::trash('memberships.delete');
		}

		// Add a export button
		JToolBarHelper::custom('memberships.export', 'export.png', 'export_f2.png', JText::_('JTOOLBAR_EXPORT'), false);

		// Add a import button
		if ($user->authorise('core.create', 'com_clubmanagement'))
		{
			JToolBarHelper::custom('memberships.import', 'import.png', 'import_f2.png', JText::_('JTOOLBAR_IMPORT'), false);
		}

		if ($user->authorise('core.admin', 'com_clubmanagement'))
		{
			JToolbarHelper::preferences('com_clubmanagement');
		}

		//JToolbarHelper::help('JHELP_CONTENT_ARTICLE_MANAGER');
	}

	protected function addToolbarImport()
	{
		// Get the toolbar object instance
		$bar = JToolBar::getInstance('toolbar');
		JToolbarHelper::title(JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_TITLE'), 'stack person');
		JToolBarHelper::custom('memberships.import_cancel', 'cancel.png', 'cancel_f2.png', JText::_('JTOOLBAR_CLOSE'), false);
	}

	/**
	 * Returns an array of fields the table can be sorted by
	 *
	 * @return  array  Array containing the field name to sort by as the key and display text as value
	 *
	 * @since   3.0
	 */
	protected function getSortFields()
	{
		return array(
			'p.name,p.firstname' => JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_FULLNAME_LABEL'),
			'p.name' => JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_NAME_LABEL'),
			'p.firstname' => JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_FIRSTNAME_LABEL'),
			'p.city' => JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_CITY_LABEL'),
			'p.birthday' => JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_BIRTHDAY_LABEL'),
			'm.type' => JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_TYPE_LABEL'),
			'm.begin' => JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_BEGIN_LABEL'),
			'm.end' => JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_END_LABEL'),
			'm.published' => JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_FIELD_PUBLISHED_LABEL')
		);
	}
}
?>
