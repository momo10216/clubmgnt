<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Board
* @copyright	Copyright (c) 2014 Norbert K�min. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

defined('_JEXEC') or die; // no direct access
$FieldPerLine=4;
$Line=5;

/*
 * Get columns
 */
$cols = array();
for ($i=1;$i<=20;$i++) {
	$field = "column_".$i;
	$cols[] = $this->paramsMenuEntry->get($field );
}
$colcount = count($cols);


/*
 * Calculate array
 */
$header = $this->getModel()->getHeader($cols);
$headers = array();
for($i=0;$i<$Line;$i++) {
	$headerFields = array();
	for($j=0;$j<$FieldPerLine;$j++) {
		$colnr = $i*$FieldPerLine+$j;
		array_push($headerFields,$header[$colnr]);
	}
	array_push($headers,implode(' ',$headerFields));
}
$this->header = $headers;

/*
 * Calculate array
 */
if ($this->items) {
	JLoader::register('SelectionHelper', JPATH_COMPONENT_ADMINISTRATOR.'/helpers/selection.php', true);
	$boardJobs = SelectionHelper::getSelection("board_jobs");
	$lastLines = array();
	foreach($this->items as $item) {
		$row = (array) $item;
		if (empty($item->person_hh_person_id)) {
			if (!empty($row["person_hh_salutation_overwrite"])) {
				$row["person_salutation"] = $row["person_hh_salutation_overwrite"];
			}
			if (!empty($row["person_hh_name_overwrite"])) {
				$row["person_name"] = $row["person_hh_name_overwrite"];
				$row["person_firstname"] = "";
			}
			$lines = array();
			for($i=0;$i<$Line;$i++) {
				for($j=0;$j<$FieldPerLine;$j++) {
					$colnr = $i*$FieldPerLine+$j;
					$field = $cols[$colnr];
					if (($field == "board_job") && !empty($boardJobs[$row[$field]])) {
						$data = $boardJobs[$row[$field]];
					} else {
						$data = $row[$field];
					}
					if (strlen($data) > 0) {
						if ($lines[$i]) { $lines[$i] .= " "; }
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
