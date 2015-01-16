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

function getparam ($key) {
	return $this->paramsMenuEntry->get($key);
}

function display_link($name, $data, $target) {
	if (count($data) < 1) {
		echo JText::_("NO_DATA");
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

function display_email_link ($label, $data) {
	echo $label."\n";
	$max_email_addr = getparam("max_email_addr");
	$target_field = getparam("target_field");
	if (($max_email_addr == 0) || ($max_email_addr >= count($data))) {
		// One link
		display_link(JText::_("LINK"), $data, $target_field);
	} else {
		// Multiple links
		$max = intval(count($data) / $max_email_addr) + 1;
		for ($i=1 ; $i<=$max ; $i++) {
			$newdata = array_slice($data, (($i-1)*$max_email_addr), $max_email_addr);
			display_link(JText::sprintf("LINK_NR",$i), $newdata, $target_field);
		}
	}
	echo "<br/>\n";
}

/*
 * Get parameters
 */
$member_type = getparam("membertype");
$member_publicity = getparam("publicity");
$member_state = getparam($this,"memberstate");

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
foreach($member_type as $type) {
	foreach($mstate as $state) {
		$where = "`p`.`type` = '".$type."' AND `p`.`email` IS NOT NULL";
		switch (strtolower($state)) {
			case "terminated":
				$where .= " AND `m`.`end` IS NOT NULL AND `m`.`end` <> '0000-00-00'";
				break;
			case "current":
				$where .= " AND (`m`.`end` IS NULL OR `m`.`end` = '0000-00-00')";
				break;
			default:
				break;
		}
		switch (strtolower($member_publicity)) {
			case "published":
				$where .= " AND `m`.`published`=1";
				break;
			case "unpublished":
				$where .= " AND `m`.`published`=0";
				break;
			default:
				break;
		}
		$date = $this->getModel()->getMembershipData($cols,$where);
		display_email_link (JText::_($type)." (".JText::_($state)."):", $data);
	}
}
?>
