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

// load tooltip behavior
$script = "/* <![CDATA[ */
Joomla.submitbutton = function(pressbutton) {
	if (pressbutton == 'persons.import_do') {
		// do field validation
		var form = document.getElementById('adminForm');
		if (form.importfile.value == \"\") {
			alert('".translate('COM_CLUBMANAGEMENT_PERSONS_IMPORT_ERROR')."');
			return false;
		}
		document.getElementById('btnImport').disabled = true;
		const loading = document.getElementById('loading');
		if (loading) {
    		loading.setAttribute('style', 'display: block;');
		}
	}
	Joomla.submitform(pressbutton);
	return true;
}
/* ]]> */";
JFactory::getDocument()->addScriptDeclaration($script);

?>
<form action="<?php echo JRoute::_('index.php?option=com_clubmanagement'); ?>" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
	<fieldset class="uploadform">
		<legend><?php echo translate('COM_CLUBMANAGEMENT_PERSONS_IMPORT_TITLE'); ?></legend>
		<div class="control-group">
			<label for="importfile" class="control-label"><?php echo translate('COM_CLUBMANAGEMENT_PERSONS_IMPORT_FILE_LABEL'); ?></label>
			<div class="controls">
				<input class="input_box" id="importfile" name="importfile" type="file" size="57" />
			</div>
		</div>

		<div class="control-group " >
			<div class="control-label"><label for="encoding" class="control-label"><?php echo translate('COM_CLUBMANAGEMENT_PERSONS_IMPORT_ENCODING_LABEL'); ?></label></div>
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
			<input class="btn btn-primary" id="btnImport" type="button" value="<?php echo translate('COM_CLUBMANAGEMENT_PERSONS_IMPORT_BUTTON'); ?>" onclick="Joomla.submitbutton('persons.import_do')" />
		</div>
	</fieldset>
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>

