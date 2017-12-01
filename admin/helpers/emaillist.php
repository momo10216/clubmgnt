<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Tools
* @copyright	Copyright (c) 2015 Norbert Kuemin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

/**
 * Email list helper.
 *
 * @package     Joomla
 * @subpackage  com_clubmanagement
 * @since       3.0
 */
class EmailListHelper {
	public static function display_link($name, $data, $target) {
		switch ($target) {
			case 'cc':
				$tfexpr = '?cc=';
				break;
			case 'bcc':
				$tfexpr = '?bcc=';
				break;
			default:
				$tfexpr = '';
				break;
		}
		$emails = array();
		foreach ($data as $row) {
			if (isset($row['person_email']) && !empty($row['person_email'])) {
				array_push($emails, $row['person_email']);
			}
		}
		if (count($emails) > 0) {
			echo '<a href="MAILTO:'.$tfexpr.implode(',',$emails).'">'.$name."</a>\n";
		} else {
			echo JText::_('COM_CLUBMANAGEMENT_NO_DATA');
		}
	}

	public static function display_email_link ($label, $data, $max_email_addr, $target_field) {
		echo $label."\n";
		if (($max_email_addr == 0) || ($max_email_addr >= count($data))) {
			// One link
			self::display_link(JText::_('COM_CLUBMANAGEMENT_LINK'), $data, $target_field);
		} else {
			// Multiple links
			$max = intval(count($data) / $max_email_addr) + 1;
			for ($i=1 ; $i<=$max ; $i++) {
				$newdata = array_slice($data, (($i-1)*$max_email_addr), $max_email_addr);
				self::display_link(JText::sprintf('COM_CLUBMANAGEMENT_LINK_NR',$i), $newdata, $target_field);
			}
		}
		echo "<br/>\n";
	}

	public static function calculateKey($row, $mode) {
		if ($mode == 'member') {
			$key = '';
			if (isset($row['member_type'])) { $key = $row['member_type']; }
			if (isset($row['member_end']) && ($row['member_end'] <> '') && ($row['member_end'] <> '0000-00-00')) {
				$key .= '_terminated';
			} else {
				$key .= '_current';
			}
			return $key;
		}
		if ($mode == 'board') {
			if (isset($row['member_end']) && ($row['board_end'] <> '') && ($row['board_end'] <> '0000-00-00')) {
				return 'terminated';
			} else {
				return 'current';
			}
		}
	}

	public static function splitdata ($items, $published, $mode) {
		$result = array();
		if ($items) {
			foreach($items as $item) {
				$row = (array) $item;
				$key = self::calculateKey($row, $mode);
				if (isset($row['person_email']) && !empty($row['person_email']) && (array_search($row['person_email'],$result) === false)) {
					$rowPublished = '0';
					switch ($mode) {
						case "member":
							if (isset($row['member_published'])) { $rowPublished = $row['member_published']; }
							break;
						case "board":
							if (isset($row['board_published'])) { $rowPublished = $row['board_published']; }
							break;
					}
					if (($published == 'all') ||
					   ($published == 'unpublished' && $rowPublished == '0') ||
					   ($published == 'published' && $rowPublished == '1')) {
						if (!isset($result[$key]) || !$result[$key]) {
							$result[$key] = array();
						}
						array_push($result[$key], $row);
					}
				}
			}
		}
		return $result;
	}

	public static function getStates($state) {
		$states = array();
		switch ($state) {
			case 'terminated': // Only terminated
				$states[]='terminated';
				break;
			case 'current': // Only Current
				$states[]='current';
				break;
			default: // All
				$states[]='terminated';
				$states[]='current';
				break;
		}
		return $states;
	}
}
?>
