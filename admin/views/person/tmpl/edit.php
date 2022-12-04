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
use Joomla\CMS\Language\Text;

function translate($key) {
    if (Version::MAJOR_VERSION == '3') {
        return JText::_($key);
    } elseif (Version::MAJOR_VERSION == '4') {
        return Text::_($key);
    }
    return $key;
}
?>
<form action="<?php echo JRoute::_('index.php?option=com_clubmanagement&view=person&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm">
    <div class="main-card">
        <div class="row">
            <div class="col-lg-6">
				<?php echo $this->form->renderField('name'); ?>
			</div>
            <div class="col-lg-6">
				<?php echo $this->form->renderField('firstname'); ?>
			</div>
		</div>
	</div>
	<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', translate('COM_CLUBMANAGEMENT_PERSONS_TAB_COMMON', true)); ?>
    <div class="row">
        <div class="col-lg-6">
            <?php echo $this->form->renderField('middlename'); ?>
            <?php echo $this->form->renderField('nickname'); ?>
            <?php echo $this->form->renderField('birthname'); ?>
            <?php echo $this->form->renderField('birthday'); ?>
            <?php echo $this->form->renderField('deceased'); ?>
            <?php echo $this->form->renderField('user_id'); ?>
            <?php echo $this->form->renderField('image'); ?>
        </div>
        <div class="col-lg-6">
            <?php echo $this->form->renderField('description'); ?>
		</div>
	</div>
    <?php echo JHtml::_('bootstrap.endTab'); ?>

    <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'address', translate('COM_CLUBMANAGEMENT_PERSONS_TAB_ADDRESS', true)); ?>
    <div class="row">
        <div class="col-lg-6">
            <?php echo $this->form->renderField('address'); ?>
            <?php echo $this->form->renderField('zip'); ?>
            <?php echo $this->form->renderField('city'); ?>
            <?php echo $this->form->renderField('state'); ?>
            <?php echo $this->form->renderField('country'); ?>
        </div>
        <div class="col-lg-6">
            <?php echo $this->form->renderField('salutation'); ?>
            <?php echo $this->form->renderField('hh_person_id'); ?>
            <?php echo $this->form->renderField('hh_salutation_override'); ?>
            <?php echo $this->form->renderField('hh_name_override'); ?>
        </div>
	</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

    <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'communication', translate('COM_CLUBMANAGEMENT_PERSONS_TAB_COMMUNICATION', true)); ?>
    <div class="row">
        <div class="col-lg-6">
            <?php echo $this->form->renderField('telephone'); ?>
            <?php echo $this->form->renderField('mobile'); ?>
        </div>
        <div class="col-lg-6">
            <?php echo $this->form->renderField('email'); ?>
            <?php echo $this->form->renderField('url'); ?>
        </div>
    </div>
    <?php echo JHtml::_('bootstrap.endTab'); ?>

    <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'custom', translate('COM_CLUBMANAGEMENT_PERSONS_TAB_CUSTOM_AND_RECORDINFO', true)); ?>
    <div class="row">
        <div class="col-lg-6">
            <?php echo $this->form->renderField('custom1'); ?>
            <?php echo $this->form->renderField('custom2'); ?>
            <?php echo $this->form->renderField('custom3'); ?>
            <?php echo $this->form->renderField('custom4'); ?>
            <?php echo $this->form->renderField('custom5'); ?>
        </div>
        <div class="col-lg-6">
            <?php echo $this->form->renderField('id'); ?>
            <?php echo $this->form->renderField('createdby'); ?>
            <?php echo $this->form->renderField('createddate'); ?>
            <?php echo $this->form->renderField('modifiedby'); ?>
            <?php echo $this->form->renderField('modifieddate'); ?>
        </div>
    </div>
    <?php echo JHtml::_('bootstrap.endTab'); ?>

    <?php echo JHtml::_('bootstrap.endTabSet'); ?>
	<input type="hidden" name="task" value="person.edit" />
	<?php echo JHtml::_('form.token'); ?>
</form>
