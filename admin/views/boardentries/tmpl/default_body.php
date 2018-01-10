<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Membership
* @copyright	Copyright (c) 2014 Norbert Kuemin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

function getDateDisplayValue($date) {
	if ($date == '0000-00-00') { return ''; }
	if ($date == '0000-00-00 00:00:00') { return ''; }
	return $date;
}

?>
<?php foreach($this->items as $i => $item): ?>
        <tr class="row<?php echo $i % 2; ?>">
                <td>
                        <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                </td>
                <td>
                        <?php echo $item->name; ?>
                </td>
                <td>
                        <?php echo $item->firstname; ?>
                </td>
                <td>
                        <?php echo $item->city; ?>
                </td>
                <td>
                        <?php echo getDateDisplayValue($item->birthday); ?>
                </td>
                <td>
                        <?php echo $item->job; ?>
                </td>
                <td>
                        <?php echo $item->sortorder; ?>
                </td>
                <td>
                        <?php echo getDateDisplayValue($item->begin); ?>
                </td>
                <td>
                        <?php echo getDateDisplayValue($item->end); ?>
                </td>
                <td>
                        <?php echo $item->published; ?>
                </td>
        </tr>
<?php endforeach; ?>

