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

use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

$currentUrl = Uri::getInstance()->toString();

// Get columns
$configCols = $this->paramsMenuEntry->get("allow_columns");
$cols = $this->getModel()->translateFieldsToColumns($configCols);
?>

<form action="<?php echo $currentUrl; ?>" method="post" name="adminForm" id="adminForm">
<?php foreach($cols as $col) { ?>
	<?php echo $this->form->renderField($col); ?>
<?php } ?>
	<p align="center">
		<button type="submit">
			<?php echo Text::_('JSAVE') ?>
		</button>
		<button type="submit" onClick="document.adminForm.task.value='cancel';">
			<?php echo Text::_('JCANCEL') ?>
		</button>
	</p>
	<input type="hidden" name="option" value="com_clubmanagement" />
	<input type="hidden" name="task" value="save" />
	<input type="hidden" name="id" value="<?php echo $this->item->id; ?>" />
	<?php echo JHtml::_('form.token'); ?>
</form>

