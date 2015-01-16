<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Membership
* @copyright	Copyright (c) 2012 Norbert Kümin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

defined('_JEXEC') or die; // no direct access

function display_link($name, $data, $target) {
	switch ($target) {
		case "cc":
			$tfexpr = "?cc=";
			break;
		case "bcc":
			$tfexpr = "?bcc=";
			break;
		default:
			$tfexpr = "";
			break;
	}
	$emails = array();
	foreach ($data as $row) {
		array_push($emails, $row['person_email']);
	}
	if (count($emails) > 0) {
		echo "<a href=\"MAILTO:".$tfexpr.implode(",",$emails)."\">".$name."</a>\n";
	} else {
		echo JText::_("COM_CLUBMANAGEMENT_NO_DATA");
	}
}

function display_email_link ($label, $data, $max_email_addr, $target_field) {
	echo $label."\n";
	if (($max_email_addr == 0) || ($max_email_addr >= count($data))) {
		// One link
		display_link(JText::_("COM_CLUBMANAGEMENT_LINK"), $data, $target_field);
	} else {
		// Multiple links
		$max = intval(count($data) / $max_email_addr) + 1;
		for ($i=1 ; $i<=$max ; $i++) {
			$newdata = array_slice($data, (($i-1)*$max_email_addr), $max_email_addr);
			display_link(JText::sprintf("COM_CLUBMANAGEMENT_LINK_NR",$i), $newdata, $target_field);
		}
	}
	echo "<br/>\n";
}

function splitdata ($items, $published) {
	$result = array();
	if ($items) {
		foreach($items as $item) {
			$row = (array) $item;
			$key = $row['member_type'];
			if (($row['member_end'] <> '') && ($row['member_end'] <> '0000-00-00')) {
				$key .= '_terminated';
			} else {
				$key .= '_current';
			}
			if ($row['person_email']) {
				if (($published == "all") ||
				   ($published == 'unpublished' && $row['member_published'] == '0') ||
				   ($published == 'published' && $row['member_published'] == '1')) {
					if (!$result[$key]) {
						$result[$key] = array();
					}
					array_push($result[$key], $row);
				}
			}
		}
	}
	return $result;
}

function getMemberType($type, $memberTypes) {
	if ($memberTypes[$type]) {
		return $memberTypes[$type];
	}
	return $type;
}

/*
 * Get parameters
 */
$member_type = $this->paramsMenuEntry->get("membertype");
$member_publicity = $this->paramsMenuEntry->get("publicity");
$member_state = $this->paramsMenuEntry->get("memberstate");
$max_email_addr = $this->paramsMenuEntry->get("max_email_addr");
$target_field = $this->paramsMenuEntry->get("target_field");

/*
 * Get email addresses for members
 */
$cols = array();
$cols[] = "email";
$mstate = array();
switch ($member_state) {
	case "terminated": // Only terminated
		$mstate[]="terminated";
		break;
	case "current": // Only Current
		$mstate[]="current";
		break;
	default: // All
		$mstate[]="terminated";
		$mstate[]="current";
		break;
}

if (!is_array($member_type)) {
	$temp = $member_type;
	$member_type = array();
	$member_type[0] = $temp;
}
reset($member_type);
JLoader::register('SelectionHelper', JPATH_COMPONENT_ADMINISTRATOR.'/helpers/selection.php', true);
$memberTypes = SelectionHelper::getSelection("member_types");
$data = splitdata($this->items, $member_publicity);
foreach($member_type as $type) {
	foreach($mstate as $state) {
		display_email_link (getMemberType($type, $memberTypes)." (".JText::_($state)."):", $data[$type.'_'.$state], $max_email_addr, $target_field);
	}
}
?>

