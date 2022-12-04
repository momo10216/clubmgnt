<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Member
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
<form action="<?php echo JRoute::_('index.php?option=com_clubmanagement&layout=edit&id=' . (int) $this->item->id); ?>"
    method="post" name="adminForm" id="adminForm">
    <div class="form-horizontal">
	<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', translate('COM_CLUBMANAGEMENT_MEMBERSHIPS_TAB_COMMON', true)); ?>
	<div class="row-fluid">
		<div class="span9">
			<div class="row-fluid form-horizontal-desktop">
				<div class="span6">
					<?php echo $this->form->renderField('person_id'); ?>
					<?php echo $this->form->renderField('type'); ?>
					<?php echo $this->form->renderField('begin'); ?>
					<?php echo $this->form->renderField('end'); ?>
					<?php echo $this->form->renderField('published'); ?>
				</div>
				<div class="span6">
					<?php echo $this->form->renderField('catid'); ?>
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
    <input type="hidden" name="task" value="membership.edit" />
    <?php echo JHtml::_('form.token'); ?>
</form>
