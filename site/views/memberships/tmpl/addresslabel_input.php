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

$doc = JFactory::getDocument();
$url = JURI::base().'components/com_clubmanagement/js/labels_data.js';
//$doc->addScript($url);
?>
<form action="<?php echo JRoute::_('index.php?option=com_clubmanagement&layout='.$this->getLayout()); ?>" method="post" name="adminForm" id="adminForm">
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
		oriontation:<select name="orientation" id="orientation" style="max-width:12em;" value="portrait"><option value="portrait">Portrait</option><option value="landscape">Landscape</option></select>
		<br/>
		Label rows:<input type="number" style="max-width:2em;" name="rows" id="rows" value="0" />
		columns:<input type="number" style="max-width:2em;" name="columns" id="columns" value="0" />
		spacing horizontal:<input type="number" style="max-width:5em;" name="spacingHorizontal" id="spacingHorizontal" value="0" />
		spacing vertical:<input type="number" style="max-width:5em;" name="spacingVertical" id="spacingVertical" value="0" />
		width:<input type="number" style="max-width:5em;" name="labelWidth" id="labelWidth" value="0" />
		height:<input type="number" style="max-width:5em;" name="labelHeight" id="labelHeight" value="0" />
	</p>
	<p align="center">
		<button type="submit">
			<?php echo JText::_('JSAVE') ?>
		</button>
		<button type="submit" onClick="document.adminForm.task.value='cancel';">
			<?php echo JText::_('JCANCEL') ?>
		</button>
	</p>
	<input type="hidden" name="option" value="com_clubmanagement" />
	<input type="hidden" name="task" value="create_pdf" />
	<?php echo JHtml::_('form.token'); ?>
</form>
<script src="<?php echo $url; ?>" type="text/javascript"></script>
