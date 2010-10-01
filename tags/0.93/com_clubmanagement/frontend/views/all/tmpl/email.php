<?php
/**
* @version		0.93
* @package		Joomla
* @subpackage	ClubManagement-Membership
* @copyright	Copyright (c) 2009 Norbert Kümin. All rights reserved.
* @license		http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author		Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

defined('_JEXEC') or die('Restricted access'); // no direct access

function getparam ($obj, $key)
{
	return $obj->params_menu->get($key);
}

function display_link($name, $data, $target) {
	if (count($data) < 1) {
		echo JText::_("NO DATA");
	} else {
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
		echo "<a href=\"MAILTO:".$tfexpr;
		$first = true;
		foreach ($data as $row) {
			if ($first === true) {
				$first = false;
			} else {
				echo ", ";
			}
			echo $row[0];
		}
		echo "\">".$name."</a>\n";
	}
}

function display_email_link ($obj, $label, $data) {
	echo $label."\n";
	$max_email_addr = getparam($obj, "max_email_addr");
	$target_field = getparam($obj, "target_field");
	if (($max_email_addr == 0) || ($max_email_addr >= count($data))) {
		// One link
		display_link(JText::_("LINK"), $data, $target_field);
	} else {
		// Multiple links
		$max = intval(count($data) / $max_email_addr) + 1;
		for ($i=1 ; $i<=$max ; $i++) {
			$newdata = array_slice($data, (($i-1)*$max_email_addr), $max_email_addr);
			display_link(JText::sprintf("LINK NR",$i), $newdata, $target_field);
		}
	}
	echo "<br/>\n";
}

/*
 * Get parameters
 */
$member_type = getparam($this,"member_type");
$member_publicity = getparam($this,"member_publicity");
$member_state_current = getparam($this,"member_state_current");
$member_state_terminated = getparam($this,"member_state_terminated");
$board_state_current = getparam($this,"board_state_current");
$board_state_terminated = getparam($this,"board_state_terminated");

/*
 * Get email addresses for members
 */
$cols = array();
$cols[] = "email";
if ($member_state_current.$member_state_terminated != "00") {
	$mstate = array();
	switch ($member_state_current.$member_state_terminated) {
		case "01": // Only terminated
			$mstate[]="terminated";
			break;
		case "10": // Only Current
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
	foreach($member_type as $type) {
		foreach($mstate as $state) {
			$where = "`type` = '".$type."' AND `email` IS NOT NULL";
			switch (strtolower($state)) {
				case "terminated":
					$where .= " AND `end` IS NOT NULL";
					break;
				case "current":
					$where .= " AND `end` IS NULL";
					break;
				default:
					break;
			}
			switch (strtolower($member_publicity)) {
				case "published":
					$where .= " AND `published`=1";
					break;
				case "unpublished":
					$where .= " AND `published`=0";
					break;
				default:
					break;
			}
			$data = $this->cmobj["member"]->getViewData($cols,$where,"");
			display_email_link ($this, JText::_($type)." (".JText::_($state)."):", $data);
		}
	}
}

/*
 * Get email addresses for board
 */
$cols = array();
$cols[] = "email";
if ($board_state_current.$board_state_terminated != "00") {
	$bstate = array();
	switch ($board_state_current.$board_state_terminated) {
		case "01": // Only terminated
			$bstate[]="terminated";
			break;
		case "10": // Only Current
			$bstate[]="current";
			break;
		default: // All
			$bstate[]="terminated";
			$bstate[]="current";
			break;
	}
	foreach($mstate as $state) {
		$where = "`email` IS NOT NULL";
		switch (strtolower($state)) {
			case "terminated":
				$where .= " AND `end` IS NOT NULL";
				break;
			case "current":
				$where .= " AND `end` IS NULL";
				break;
			default:
				break;
		}
		switch (strtolower($member_publicity)) {
			case "published":
				$where .= " AND `published`=1";
				break;
			case "unpublished":
				$where .= " AND `published`=0";
				break;
			default:
				break;
		}
		$data = $this->cmobj["board"]->getViewData($cols,$where,"");
		display_email_link ($this, JText::_("board")." (".JText::_($state)."):", $data);
	}
}
?>