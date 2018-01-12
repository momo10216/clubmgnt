<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Member
* @copyright	Copyright (c) 2012 Norbert KUEmin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

function displayEntry($row) {
?>
		<tr>
			<td><input class="cbRow" name="is_selected[]" type="checkbox" /></td>
			<td><?php echo $row['person_name']; ?></td>
			<td><?php echo $row['person_firstname']; ?></td>
			<td><?php echo $row['person_city']; ?></td>
			<td>
<?php foreach($row as $column => $value) { ?>
				<input name="<?php echo $column; ?>[]" value="<?php echo $value; ?>" type="hidden" />
<?php } ?>
			</td>
		</tr>
<?php
}

$doc = JFactory::getDocument();
$urlData = JURI::base().'components/com_clubmanagement/js/labels_data.js';
$urlFunc = JURI::base().'components/com_clubmanagement/js/labels_func.js';
$doc->addScript($urlData);
$doc->addScriptDeclaration("function checkAll(cbAll) {
	var cbs = document.getElementsByClassName('cbRow');
	for(var i = 0; i < cbs.length; i++) {
		cbs[i].checked = cbAll.checked;
	}
}");
?>
<form action="<?php echo JRoute::_('index.php?option=com_clubmanagement&layout='.$this->getLayout()); ?>" method="post" name="addressLabelForm" id="addressLabelForm">
	<p align="left">
		Producer:<select name="producer" id="producer" style="max-width:12em;" value="" onChange="producerSelected()"></select>
		Format:<select name="format" id="format" style="max-width:12em;" value="" onChange="formatSelected()"></select>
		Product:<select name="product" id="product" style="max-width:20em;" value="" onChange="productSelected()"></select>
	</p>
	<p align="left">
		Page width:<input type="number" style="max-width:5em;" name="pageWidth" id="pageWidth" value="210" />
		height:<input type="number" style="max-width:5em;" name="pageHeight" id="pageHeight" value="297" />
		marginTop:<input type="number" style="max-width:5em;" name="pageMarginTop" id="pageMarginTop" value="0" />
		marginLeft:<input type="number" style="max-width:5em;" name="pageMarginLeft" id="pageMarginLeft" value="0" />
		oriontation:<select name="pageOrientation" id="pageOrientation" style="max-width:12em;" value="portrait"><option value="portrait">Portrait</option><option value="landscape">Landscape</option></select>
		<br/>
		Label rows:<input type="number" style="max-width:3em;" name="rows" id="rows" value="0" />
		columns:<input type="number" style="max-width:3em;" name="columns" id="columns" value="0" />
		spacing horizontal:<input type="number" style="max-width:5em;" name="spacingHorizontal" id="spacingHorizontal" value="0" />
		spacing vertical:<input type="number" style="max-width:5em;" name="spacingVertical" id="spacingVertical" value="0" />
		width:<input type="number" style="max-width:5em;" name="labelWidth" id="labelWidth" value="0" />
		height:<input type="number" style="max-width:5em;" name="labelHeight" id="labelHeight" value="0" />
	</p>
	<table>
		<tr>
			<th><input name="checkall-toggle" id="checkall-toggle" value="" class="hasTooltip" title="" onclick="checkAll(this)" type="checkbox" /></th>
			<th><?php echo JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_NAME_LABEL'); ?></th>
			<th><?php echo JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_FIRSTNAME_LABEL'); ?></th>
			<th><?php echo JText::_('COM_CLUBMANAGEMENT_PERSONS_FIELD_CITY_LABEL'); ?></th>
		</tr>
<?php
foreach($this->items as $item) {
	$row = (array) $item;
	displayEntry($row);
	if (!empty($row['person_hh_name_override'])) {
		$row['person_name'] = $row['person_hh_name_override'];
		$row['person_salutation'] = $row['person_hh_salutation_override'];
		$row['person_firstname'] = '';
		displayEntry($row);
	}
}
?>
	</table>
	<p align="center">
		<button type="submit">
			<?php echo JText::_('JSUBMIT'); ?>
		</button>
	</p>
	<input type="hidden" name="option" value="com_clubmanagement" />
	<input type="hidden" name="task" value="create_pdf" />
	<?php echo JHtml::_('form.token'); ?>
</form>
<script src="<?php echo $urlFunc; ?>" type="text/javascript"></script>
<script type="text/javascript">document.getElementById('checkall-toggle').checked = true; checkAll(document.getElementById('checkall-toggle'));</script>
