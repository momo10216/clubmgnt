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

$FieldPerLine=4;
$Line=5;
$this->filename = date('Y-m-d') . '_address_export' . '.csv';
// Get columns
$cols = array();
for ($i=1;$i<=20;$i++) {
	$field = 'column_'.$i;
	$cols[$i-1] = $this->paramsMenuEntry->get($field);
}
$colcount = count($cols);
// Calculate array
$header = $this->getModel()->getHeader($cols, true);
$headers = array();
for($i=0;$i<$Line;$i++) {
	$headerFields = array();
	for($j=0;$j<$FieldPerLine;$j++) {
		$colnr = $i*$FieldPerLine+$j;
		if (!empty($header[$colnr])) {
			array_push($headerFields,$header[$colnr]);
		}
	}
	array_push($headers,implode(' ',$headerFields));
}
$this->header = $headers;
JLoader::register('SelectionHelper', JPATH_COMPONENT_ADMINISTRATOR.'/helpers/selection.php', true);
$memberTypes = SelectionHelper::getSelection('member_types');
// Calculate array
if ($this->items) {
	$lastLines = array();
	foreach($this->items as $item) {
		$row = (array) $item;
		if (empty($item->person_hh_person_id)) {
			if (isset($row["person_hh_name_override"]) && !empty($row["person_hh_name_override"])) {
				if (isset($row["person_hh_salutation_override"]) && !empty($row["person_hh_salutation_override"])) {
					$row["person_salutation"] = $row["person_hh_salutation_override"];
				} else {
					$row["person_salutation"] = "";
				}
				$row["person_name"] = $row["person_hh_name_override"];
				$row["person_firstname"] = "";
			}
			$lines = array();
			for($i=0;$i<$Line;$i++) {
				$lines[$i] = '';
				for($j=0;$j<$FieldPerLine;$j++) {
					$colnr = $i*$FieldPerLine+$j;
					$field = $cols[$colnr];
					$data = '';
					if (($field == 'member_type') && !empty($memberTypes[$row[$field]])) {
						$data = $memberTypes[$row[$field]];
					} else {
						if (isset($row[$field])) { $data = $row[$field]; }
					}
					if (strlen($data) > 0) {
						if ($lines[$i]) { $lines[$i] .= ' '; }
						$lines[$i] .= $data;
						$lines[$i] = trim($lines[$i]);
					}
				}
			}
			if ($lastLines != $lines) {
				array_push($this->data,$lines);
				$lastLines = $lines;
			}
		}
	}
}
?>
