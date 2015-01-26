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

// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
?>
<form action="<?php echo JRoute::_('index.php?option=com_clubmanagement&layout=edit&id=' . (int) $this->item->id); ?>"
    method="post" name="adminForm" id="adminForm">
	<div class="row-fluid">
		<div class="span9">
			<div class="row-fluid form-horizontal-desktop">
				<div class="span6">
					<?php echo $this->form->renderField('name'); ?>
				</div>
				<div class="span6">
					<?php echo $this->form->renderField('firstname'); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_CLUBMANAGEMENT_PERSONS_TAB_COMMON', true)); ?>
		<div class="row-fluid">
			<div class="span9">
				<div class="row-fluid form-horizontal-desktop">
					<div class="span6">
						<?php echo $this->form->renderField('middlename'); ?>
						<?php echo $this->form->renderField('nickname'); ?>
						<?php echo $this->form->renderField('birthname'); ?>
						<?php echo $this->form->renderField('birthday'); ?>
						<?php echo $this->form->renderField('deceased'); ?>
						<?php echo $this->form->renderField('user_id'); ?>
						<?php echo $this->form->renderField('image'); ?>
					</div>
					<div class="span6">
						<?php echo $this->form->renderField('description'); ?>
					</div>
				</div>
			</div>
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'address', JText::_('COM_CLUBMANAGEMENT_PERSONS_TAB_ADDRESS', true)); ?>
		<div class="row-fluid">
			<div class="span9">
				<div class="row-fluid form-horizontal-desktop">
					<div class="span6">
						<?php echo $this->form->renderField('address'); ?>
						<?php echo $this->form->renderField('zip'); ?>
						<?php echo $this->form->renderField('city'); ?>
						<?php echo $this->form->renderField('state'); ?>
						<?php echo $this->form->renderField('country'); ?>
					</div>
					<div class="span6">
						<?php echo $this->form->renderField('salutation'); ?>
						<?php echo $this->form->renderField('hh_person_id'); ?>
						<?php echo $this->form->renderField('hh_salutation_override'); ?>
						<?php echo $this->form->renderField('hh_name_override'); ?>
					</div>
				</div>
			</div>
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'communication', JText::_('COM_CLUBMANAGEMENT_PERSONS_TAB_COMMUNICATION', true)); ?>
		<div class="row-fluid">
			<div class="span9">
				<div class="row-fluid form-horizontal-desktop">
					<div class="span6">
						<?php echo $this->form->renderField('telephone'); ?>
						<?php echo $this->form->renderField('mobile'); ?>
					</div>
					<div class="span6">
						<?php echo $this->form->renderField('email'); ?>
						<?php echo $this->form->renderField('url'); ?>
					</div>
				</div>
			</div>
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'custom', JText::_('COM_CLUBMANAGEMENT_PERSONS_TAB_CUSTOM_AND_RECORDINFO', true)); ?>
		<div class="row-fluid">
			<div class="span9">
				<div class="row-fluid form-horizontal-desktop">
					<div class="span6">
						<?php echo $this->form->renderField('custom1'); ?>
						<?php echo $this->form->renderField('custom2'); ?>
						<?php echo $this->form->renderField('custom3'); ?>
						<?php echo $this->form->renderField('custom4'); ?>
						<?php echo $this->form->renderField('custom5'); ?>
					</div>
					<div class="span6">
						<?php echo $this->form->renderField('id'); ?>
						<?php echo $this->form->renderField('createdby'); ?>
						<?php echo $this->form->renderField('createddate'); ?>
						<?php echo $this->form->renderField('modifiedby'); ?>
						<?php echo $this->form->renderField('modifieddate'); ?>
					</div>
				</div>
			</div>
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

		<?php echo JHtml::_('bootstrap.endTabSet'); ?>
	</div>
	<input type="hidden" name="task" value="person.edit" />
	<?php echo JHtml::_('form.token'); ?>
</form>
