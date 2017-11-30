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

$listDirn	= $this->escape($this->state->get('list.direction'));
$listOrder	= $this->escape($this->state->get('list.ordering'));
?>
<tr>
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
		<?php echo JHtml::_('grid.sort', 'COM_CLUBMANAGEMENT_PERSONS_FIELD_BIRTHDAY_LABEL', 'p.country', $listDirn, $listOrder); ?>
	</th>
</tr>

