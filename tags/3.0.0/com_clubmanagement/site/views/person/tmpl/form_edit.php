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
defined('_JEXEC') or die; // no direct access

// Get columns
$confCols = $this->paramsMenuEntry->get("allow_columns");
$cols = $this->getModel()->translateFieldsToColumns($confCols);

$script = <<<EOD
/* <![CDATA[ */
Joomla.submitbutton = function(pressbutton) {
	submitform(pressbutton);
	return true;
}
/* ]]> */
EOD;
JFactory::getDocument()->addScriptDeclaration($script);
?>

<form action="<?php echo JRoute::_('index.php?option=com_clubmanagement&layout='.$this->getLayout().'&id='.$this->item->id); ?>" method="post" name="adminForm" id="adminForm">
	<?php foreach($cols as $col) { ?>
		<?php echo $this->form->renderField($col); ?>
	<?php } ?>

<p align="center">
	<button type="button" onclick="submitbutton('save')">
		<?php echo JText::_('JSAVE') ?>
	</button>
	<button type="button" onclick="submitbutton('cancel')">
		<?php echo JText::_('JCANCEL') ?>
	</button>
</p>
	<input type="hidden" name="task" value="person.submit" />
	<?php echo JHtml::_('form.token'); ?>
</form>

