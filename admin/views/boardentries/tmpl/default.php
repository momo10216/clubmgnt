<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Board
* @copyright	Copyright (c) 2014 Norbert Kuemin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
 
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$listDirn	= $this->escape($this->state->get('list.direction'));
$listOrder	= $this->escape($this->state->get('list.ordering'));
$sortFields	= $this->getSortFields();

$script = <<<EOD
/* <![CDATA[ */
Joomla.submitbutton = function(pressbutton) {
	submitform(pressbutton);
	return true;
}
/* ]]> */
EOD;
JFactory::getDocument()->addScriptDeclaration($script);
$script = "/* <![CDATA[ */
Joomla.orderTable = function()
{
	table = document.getElementById(\"sortTable\");
	direction = document.getElementById(\"directionTable\");
	order = table.options[table.selectedIndex].value;
	if (order != '".$listOrder."')
	{
		dirn = 'asc';
	}
	else
	{
		dirn = direction.options[direction.selectedIndex].value;
	}
	Joomla.tableOrdering(order, dirn, '');
}";
JFactory::getDocument()->addScriptDeclaration($script);
?>
<form action="<?php echo JRoute::_('index.php?option=com_clubmanagement&view=boardentries'); ?>" method="post" name="adminForm" id="adminForm">
<?php if (!empty( $this->sidebar)) : ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
<?php else : ?>
	<div id="j-main-container">
<?php endif;?>
<?php echo $this->loadTemplate('filter');?>
		<div class="clearfix"> </div>
		<table class="table adminlist">
		        <thead><?php echo $this->loadTemplate('head');?></thead>
		        <tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
		        <tbody><?php echo $this->loadTemplate('body');?></tbody>
		</table>
	</div>
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
	<?php echo JHtml::_('form.token'); ?>
</form>
