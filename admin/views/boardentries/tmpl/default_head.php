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

$listDirn	= $this->escape($this->state->get('list.direction'));
$listOrder	= $this->escape($this->state->get('list.ordering'));
?>
<tr>
	<th width="1%" class="hidden-phone">
		<?php echo JHtml::_('grid.checkall'); ?>
	</th>
	<th>
		<?php echo JHtml::_('grid.sort', 'COM_CLUBMANAGEMENT_PERSONS_FIELD_NAME_LABEL', 'p.name', $listDirn, $listOrder); ?>
	</th>
	<th>
		<?php echo JHtml::_('grid.sort', 'COM_CLUBMANAGEMENT_PERSONS_FIELD_FIRSTNAME_LABEL', 'p.firstname', $listDirn, $listOrder); ?>
	</th>
	<th>
		<?php echo JHtml::_('grid.sort', 'COM_CLUBMANAGEMENT_PERSONS_FIELD_CITY_LABEL', 'p.city', $listDirn, $listOrder); ?>
	</th>
	<th>
		<?php echo JHtml::_('grid.sort', 'COM_CLUBMANAGEMENT_PERSONS_FIELD_BIRTHDAY_LABEL', 'p.birthday', $listDirn, $listOrder); ?>
	</th>
	<th>
		<?php echo JHtml::_('grid.sort', 'COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_JOB_LABEL', 'b.job', $listDirn, $listOrder); ?>
	</th>
	<th>
		<?php echo JHtml::_('grid.sort', 'COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_SORTORDER_LABEL', 'b.sortorder', $listDirn, $listOrder); ?>
	</th>
	<th>
		<?php echo JHtml::_('grid.sort', 'COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_BEGIN_LABEL', 'b.begin', $listDirn, $listOrder); ?>
	</th>
	<th>
		<?php echo JHtml::_('grid.sort', 'COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_END_LABEL', 'b.end', $listDirn, $listOrder); ?>
	</th>
	<th>
		<?php echo JHtml::_('grid.sort', 'COM_CLUBMANAGEMENT_BOARDENTRIES_FIELD_PUBLISHED_LABEL', 'b.published', $listDirn, $listOrder); ?>
	</th>
</tr>

