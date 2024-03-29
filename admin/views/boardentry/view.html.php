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

class ClubManagementViewBoardEntry extends JViewLegacy {
	protected $form;
	protected $item;
	protected $state;
	protected $canDo;

	/**
	 * Display the view
	 */
	public function display($tpl = null) {
		$this->form	= $this->get('Form');
		$this->item	= $this->get('Item');
		$this->state	= $this->get('State');
		$this->canDo	= ClubManagementHelper::getActions('com_clubmanagement', 'boardentry', $this->item->id);
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}
		$this->addToolbar();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since   1.6
	 */
	protected function addToolbar() {
		JFactory::getApplication()->input->set('hidemainmenu', true);
		$user		= JFactory::getUser();
		$userId		= $user->get('id');
		$isNew		= ($this->item->id == 0);
		// Built the actions for new and existing records.
		$canDo		= $this->canDo;
		JToolbarHelper::title(($isNew ? Text::_('COM_CLUBMANAGEMENT_BOARDENTRIES_PAGE_ADD') : Text::_('COM_CLUBMANAGEMENT_BOARDENTRIES_PAGE_EDIT')), 'pencil-2 article-add');
		// For new records, check the create permission.
		if ($isNew && $canDo->get('core.create')) {
			JToolbarHelper::apply('boardentry.apply');
			JToolbarHelper::save('boardentry.save');
			JToolbarHelper::save2new('boardentry.save2new');
			JToolbarHelper::cancel('boardentry.cancel');
		} else {
			// Since it's an existing record, check the edit permission, or fall back to edit own if the owner.
			if ($canDo->get('core.edit') || ($canDo->get('core.edit.own') && $this->item->created_by == $userId)) {
				JToolbarHelper::apply('boardentry.apply');
				JToolbarHelper::save('boardentry.save');
				// We can save this record, but check the create permission to see if we can return to make a new one.
				if ($canDo->get('core.create')) {
					JToolbarHelper::save2new('boardentry.save2new');
				}
			}
			// If checked out, we can still save
			if ($canDo->get('core.create')) {
				JToolbarHelper::save2copy('boardentry.save2copy');
			}
			JToolbarHelper::cancel('boardentry.cancel', 'JTOOLBAR_CLOSE');
		}
		JToolbarHelper::divider();
		JToolbarHelper::help('JHELP_COM_CLUBMANAGEMENT_BOARDENTRIES_MANAGER_EDIT');
	}
}
?>
