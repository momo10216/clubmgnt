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
$url = (isset($_SERVER['HTTPS']) ? "https" : "http").'://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'])[0].'components/com_clubmanagement/js/labels_data.js';
$doc->addScript($url);
?>
<form action="<?php echo JRoute::_('index.php?option=com_clubmanagement&layout='.$this->getLayout()); ?>" method="post" name="adminForm" id="adminForm">
	<p align="left">
		Producer:<select name="producer" value="" onSelect="producerSelected()"/>
		Format:<select name="format" value="" onSelect="formatSelected()"/>
		Product:<select name="product" value="" onSelect="productSelected()"/>
	</p>
	<p align="left">
		Page width:<input type="number" name="pageWidth" value="210" />
		height:<input type="number" name="pageHeight" value="297" />
		marginTop:<input type="number" name="pageMarginTop" value="0" />
		marginLeft:<input type="number" name="pageMarginLeft" value="0" />
		oriontation:<select name="pageHeight" value="297"><option value="portrait">Portrait</option><option value="landscape">Landscape</option></select>
		<br/>
		Label rows:<input type="number" name="rows" value="0" />
		columns:<input type="number" name="columns" value="0" />
		spacing horizontal:<input type="number" name="spacingHorizontal" value="0" />
		spacing vertical:<input type="number" name="spacingVertical" value="0" />
		width:<input type="number" name="labelWidth" value="0" />
		height:<input type="number" name="labelHeight" value="0" />
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

