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

// Get columns
$confCols = $this->paramsMenuEntry->get("allow_columns");
$cols = $this->getModel()->translateFieldsToColumns($confCols);
?>

<form action="<?php echo JRoute::_('index.php?option=com_clubmanagement&layout='.$this->getLayout().'&id='.$this->item->id); ?>" method="post" name="adminForm" id="adminForm">
<?php foreach($cols as $col) { ?>
	<?php echo $this->form->renderField($col); ?>
<?php } ?>
	<p align="center">
		<button type="submit">
			<?php echo JText::_('JSAVE') ?>
		</button>
		<button type="submit" onClick="document.adminForm.task.value='cancel';">
			<?php echo JText::_('JCANCEL') ?>
		</button>
	</p>
	<input type="hidden" name="option" value="com_clubmanagement" />
	<input type="hidden" name="task" value="save" />
	<?php echo JHtml::_('form.token'); ?>
</form>

