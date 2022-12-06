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

use Joomla\CMS\Language\Text;

/**
 * Board View
 */
class ClubManagementViewBoardEntries extends JViewLegacy {
	public $filterForm;
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Persons view display method
	 * @return void
	 */

	function display($tpl = null)  {
		// Get data from the model
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$this->state = $this->get('State');
		$this->filterForm = $this->get('FilterForm');
		// Check for errors.
		if ($this->get('Errors') && count($errors = $this->get('Errors')) > 0) {
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
		JToolbarHelper::title(Text::_('COM_CLUBMANAGEMENT_BOARDENTRIES_TITLE'), 'stack board');
		if ($canDo->get('core.create') || (count($user->getAuthorisedCategories('com_clubmanagement', 'core.create'))) > 0 ) {
			JToolbarHelper::addNew('boardentry.add');
		}
		if (($canDo->get('core.edit')) || ($canDo->get('core.edit.own'))) {
			JToolbarHelper::editList('boardentry.edit');
		}
		if ($this->state->get('filter.published') == -2 && $canDo->get('core.delete')) {
			JToolbarHelper::deleteList('', 'boardentries.delete', 'JTOOLBAR_EMPTY_TRASH');
		} elseif ($canDo->get('core.edit.state')) {
			JToolbarHelper::trash('boardentries.delete');
		}
		// Add a export button
		JToolBarHelper::custom('boardentries.export', 'export.png', 'export_f2.png', Text::_('JTOOLBAR_EXPORT'), false);
		// Add a import button
		if ($user->authorise('core.create', 'com_clubmanagement')) {
			JToolBarHelper::custom('boardentries.import', 'import.png', 'import_f2.png', Text::_('JTOOLBAR_IMPORT'), false);
		}
		if ($user->authorise('core.admin', 'com_clubmanagement')) {
			JToolbarHelper::preferences('com_clubmanagement');
		}
		//JToolbarHelper::help('JHELP_CONTENT_ARTICLE_MANAGER');
	}

	protected function addToolbarImport() {
		// Get the toolbar object instance
		$bar = JToolBar::getInstance('toolbar');
		JToolbarHelper::title(Text::_('COM_CLUBMANAGEMENT_BOARDENTRIES_TITLE'), 'stack board');
		JToolBarHelper::custom('boardentries.import_cancel', 'cancel.png', 'cancel_f2.png', Text::_('JTOOLBAR_CLOSE'), false);
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
			'p.name,p.firstname' => Text::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_FULLNAME_LABEL'),
			'p.name' => Text::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_NAME_LABEL'),
			'p.firstname' => Text::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_FIRSTNAME_LABEL'),
			'p.city' => Text::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_CITY_LABEL'),
			'p.birthday' => Text::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_BIRTHDAY_LABEL'),
			'm.job' => Text::_('COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_JOB_LABEL'),
			'm.sortorder' => Text::_('COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_SORTORDER_LABEL'),
			'm.begin' => Text::_('COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_BEGIN_LABEL'),
			'm.end' => Text::_('COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_END_LABEL'),
			'm.published' => Text::_('COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_PUBLISHED_LABEL')
		);
	}
}
?>
