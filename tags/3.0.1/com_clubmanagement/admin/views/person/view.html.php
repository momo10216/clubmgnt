<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Person
* @copyright	Copyright (c) 2014 Norbert Kümin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

defined('_JEXEC') or die;

class ClubManagementViewPerson extends JViewLegacy
{
	protected $form;
	protected $item;
	protected $state;
	protected $canDo;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$this->form	= $this->get('Form');
		$this->item	= $this->get('Item');
		$this->state	= $this->get('State');
		$this->canDo	= ClubManagementHelper::getActions('com_clubmanagement', 'person', $this->item->id);

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
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
	protected function addToolbar()
	{
		JFactory::getApplication()->input->set('hidemainmenu', true);
		$user		= JFactory::getUser();
		$userId		= $user->get('id');
		$isNew		= ($this->item->id == 0);

		// Built the actions for new and existing records.
		$canDo		= $this->canDo;
			JToolbarHelper::title(JText::_('COM_CLUBMANAGEMENT_PERSONS_PAGE_' . ($isNew ? 'ADD' : 'EDIT')), 'pencil-2 article-add');

		// For new records, check the create permission.
		if ($isNew && $canDo->get('core.create'))
		{
			JToolbarHelper::apply('person.apply');
			JToolbarHelper::save('person.save');
			JToolbarHelper::save2new('person.save2new');
			JToolbarHelper::cancel('person.cancel');
		}
		else
		{
			// Since it's an existing record, check the edit permission, or fall back to edit own if the owner.
			if ($canDo->get('core.edit') || ($canDo->get('core.edit.own') && $this->item->created_by == $userId))
			{
				JToolbarHelper::apply('person.apply');
				JToolbarHelper::save('person.save');

				// We can save this record, but check the create permission to see if we can return to make a new one.
				if ($canDo->get('core.create'))
				{
					JToolbarHelper::save2new('person.save2new');
				}
			}

			// If checked out, we can still save
			if ($canDo->get('core.create'))
			{
				JToolbarHelper::save2copy('person.save2copy');
			}

			JToolbarHelper::cancel('person.cancel', 'JTOOLBAR_CLOSE');
		}

		JToolbarHelper::divider();
		JToolbarHelper::help('JHELP_COM_CLUBMANAGEMENT_PERSON_MANAGER_EDIT');
	}
}
