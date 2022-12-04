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

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');
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

$app = JFactory::getApplication();
$function	= $app->input->getCmd('function', 'jSelectPerson');
$listDirn	= $this->escape($this->state->get('list.direction'));
$listOrder	= $this->escape($this->state->get('list.ordering'));
$sortFields	= $this->getSortFields();
?>
<form action="<?php echo JRoute::_('index.php?option=com_clubmanagement&view=persons&layout=modal&tmpl=component&function='.$function.'&'.JSession::getFormToken().'=1'); ?>" method="post" name="adminForm" id="adminForm">
<?php echo $this->loadTemplate('filter');?>
		<div class="clearfix"> </div>
		<table class="table table-striped table-condensed">
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

