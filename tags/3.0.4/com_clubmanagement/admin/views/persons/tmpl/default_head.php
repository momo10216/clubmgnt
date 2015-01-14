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

// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

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
		<?php echo JHtml::_('grid.sort', 'COM_CLUBMANAGEMENT_PERSONS_FIELD_ADDRESS_LABEL', 'p.address', $listDirn, $listOrder); ?>
	</th>
	<th>
		<?php echo JHtml::_('grid.sort', 'COM_CLUBMANAGEMENT_PERSONS_FIELD_ZIP_LABEL', 'p.zip', $listDirn, $listOrder); ?>
	</th>
	<th>
		<?php echo JHtml::_('grid.sort', 'COM_CLUBMANAGEMENT_PERSONS_FIELD_CITY_LABEL', 'p.city', $listDirn, $listOrder); ?>
	</th>
	<th>
		<?php echo JHtml::_('grid.sort', 'COM_CLUBMANAGEMENT_PERSONS_FIELD_STATE_LABEL', 'p.state', $listDirn, $listOrder); ?>
	</th>
	<th>
		<?php echo JHtml::_('grid.sort', 'COM_CLUBMANAGEMENT_PERSONS_FIELD_COUNTRY_LABEL', 'p.country', $listDirn, $listOrder); ?>
	</th>
</tr>

