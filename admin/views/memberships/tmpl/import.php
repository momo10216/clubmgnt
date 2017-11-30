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
 
// load tooltip behavior
JHtml::_('behavior.tooltip');
$script = "/* <![CDATA[ */
Joomla.submitbutton = function(pressbutton) {
	if (pressbutton == 'persons.import_do')
	{
		// do field validation
		var form = document.getElementById('adminForm');
		if (form.importfile.value == \"\")
		{
			alert('".JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_IMPORT_ERROR')."');
			return false;
		}
		jQuery('#loading').css('display', 'block');
	}
	submitform(pressbutton);
	return true;
}
/* ]]> */";
JFactory::getDocument()->addScriptDeclaration($script);
?>
<form action="<?php echo JRoute::_('index.php?option=com_clubmanagement'); ?>" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
	<fieldset class="uploadform">
		<legend><?php echo JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_IMPORT_TITLE'); ?></legend>
		<div class="control-group">
			<label for="importfile" class="control-label"><?php echo JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_IMPORT_FILE_LABEL'); ?></label>
			<div class="controls">
				<input class="input_box" id="importfile" name="importfile" type="file" size="57" />
			</div>
		</div>

		<div class="control-group " >
			<div class="control-label"><label for="encoding" class="control-label"><?php echo JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_IMPORT_ENCODING_LABEL'); ?></label></div>
			<div class="controls">
				<select id="encoding" name="encoding" class="chzn-container chzn-container-single chzn-container-single-nosearch">
					<option value="ASCII">ASCII</option>
					<option value="ISO-8859-1">ISO-8859-1</option>
					<option value="ISO-8859-2">ISO-8859-2</option>
					<option value="ISO-8859-3">ISO-8859-3</option>
					<option value="ISO-8859-4">ISO-8859-4</option>
					<option value="ISO-8859-5">ISO-8859-5</option>
					<option value="ISO-8859-6">ISO-8859-6</option>
					<option value="ISO-8859-7">ISO-8859-7</option>
					<option value="ISO-8859-8">ISO-8859-8</option>
					<option value="ISO-8859-9">ISO-8859-9</option>
					<option value="ISO-8859-10">ISO-8859-10</option>
					<option value="ISO-8859-11">ISO-8859-11</option>
					<option value="ISO-8859-12">ISO-8859-12</option>
					<option value="ISO-8859-13">ISO-8859-13</option>
					<option value="ISO-8859-14">ISO-8859-14</option>
					<option value="ISO-8859-15">ISO-8859-15</option>
					<option selected="selected" value="UTF-8">UTF-8</option>
					<option value="UTF-16">UTF-16</option>
				</select>
			</div>
		</div>

		<div class="form-actions">
			<input class="btn btn-primary" type="button" value="<?php echo JText::_('COM_CLUBMANAGEMENT_MEMBERSHIPS_IMPORT_BUTTON'); ?>" onclick="Joomla.submitbutton('memberships.import_do')" />
		</div>
	</fieldset>
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>

