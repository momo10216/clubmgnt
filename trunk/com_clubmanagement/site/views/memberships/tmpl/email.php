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

function calculateKey($row, $mode) {
	if ($mode == 'member') {
		$key = $row['member_type'];
		if (($row['member_end'] <> '') && ($row['member_end'] <> '0000-00-00')) {
			$key .= '_terminated';
		} else {
			$key .= '_current';
		}
		return $key;
	}
	if ($mode == 'board') {
		if (($row['board_end'] <> '') && ($row['board_end'] <> '0000-00-00')) {
			return 'terminated';
		} else {
			return 'current';
		}
	}
}

function splitdata ($items, $published, $mode) {
	$result = array();
	if ($items) {
		foreach($items as $item) {
			$row = (array) $item;
			$key = calculateKey($row, $mode);
			if ($row['person_email']) {
				switch ($mode) {
					case "member":
						$rowPublished = $row['member_published'];
						break;
					case "board":
						$rowPublished = $row['board_published'];
						break;
					default:
						$rowPublished = '0';
						break;
				}
				if (($published == "all") ||
				   ($published == 'unpublished' && $rowPublished == '0') ||
				   ($published == 'published' && $rowPublished == '1')) {
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

function getStates($state) {
	$states = array();
	switch ($state) {
		case "terminated": // Only terminated
			$states[]="terminated";
			break;
		case "current": // Only Current
			$states[]="current";
			break;
		default: // All
			$states[]="terminated";
			$states[]="current";
			break;
	}
	return $states;
}

/*
 * Get parameters
 */
$memberType = $this->paramsMenuEntry->get("membertype");
$memberPublicity = $this->paramsMenuEntry->get("memberpublicity");
$memberState = $this->paramsMenuEntry->get("memberstate");
$boardPublicity = $this->paramsMenuEntry->get("memberpublicity");
$boardState = $this->paramsMenuEntry->get("memberstate");
$maxEmailAddr = $this->paramsMenuEntry->get("max_email_addr");
$targetField = $this->paramsMenuEntry->get("target_field");

/*
 * Get email addresses for members
 */
$cols = array();
$cols[] = "email";
$mstate = getStates($memberState);
$bstate = getStates($boardState);
if (!is_array($memberType)) {
	$temp = $memberType;
	$memberType = array();
	$memberType[0] = $temp;
}
reset($memberType);
JLoader::register('SelectionHelper', JPATH_COMPONENT_ADMINISTRATOR.'/helpers/selection.php', true);
$memberTypes = SelectionHelper::getSelection("member_types");
$data = splitdata($this->items, $memberPublicity,'member');
foreach($memberType as $type) {
	foreach($mstate as $state) {
		display_email_link (getMemberType($type, $memberTypes)." (".JText::_($state)."):", $data[$type.'_'.$state], $maxEmailAddr, $targetField);
	}
}
/*
if ($this->paramsMenuEntry->get('boardshow') == '1') {
	$modelBoard = $this->getModel( 'boardentries' );
	$data = splitdata($modelBoard->get('items'), $boardPublicity,'board');
	foreach($bstate as $state) {
		display_email_link (JText::_("COM_CLUBMANAGEMENT_BOARD")." (".JText::_($state)."):", $data[$state], $maxEmailAddr, $targetField);
	}
}
*/
?>

