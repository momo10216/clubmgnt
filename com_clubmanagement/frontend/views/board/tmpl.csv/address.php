<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Board
* @copyright	Copyright (c) 2012 Norbert Kümin. All rights reserved.
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
$pos = array();
$header = array();
for ($i=1;$i<=20;$i++) {
	$field = "column_".$i;
	if ($this->params_menu->get( $field ) != "") {
		$key = intval(($i-1)/$FieldPerLine)."_".bcmod(($i-1),$FieldPerLine);
		$cols[] = $this->params_menu->get( $field );
		$pos[$key] = count($cols)-1;
		$header[$key] = $this->cmobject->column_view[$this->params_menu->get( $field )];
	}
}

/*
 * Get sort
 */
$sort = "";
for ($i=1;$i<=4;$i++) {
	$field1 = "sort_column_".$i;
	$field2 = "sort_direction_".$i;
	if ($this->params_menu->get($field1) != "") {
		$sort .= ",`".$this->params_menu->get($field1)."` ".$this->params_menu->get($field2);
	}
}
if ($sort != "") $sort = substr($sort,1);

/*
 * Calculate where
 */
//$where = "`hh_person_id` IS NULL";
$where = "`deceased` IS NULL AND `published`=1";
if ($this->params_menu->get( 'boardstate' ) == "current") {
	$where .= " AND `end` IS NULL";
}
if ($this->params_menu->get( 'boardstate' ) == "closed") {
	$where .= " AND `end` IS NOT NULL";
}
if ($this->params_menu->get( 'publicity' ) == "published") {
	if ($where != "") { $where = $where . " AND "; } 
	$where .= "`published`=1";
}
if ($this->params_menu->get( 'publicity' ) == "unpublished") {
	if ($where != "") { $where = $where . " AND "; } 
	$where .= "`published`=0";
}

/*
 * Get data
 */
$this->filename = date('Y-m-d') . '_board_address' . '.csv';
$cols[] = "hh_salutation_override";
$cols[] = "hh_name_override";
$cols[] = "hh_person_id";
$cols[] = "person_id";
$rows = $this->cmobject->getViewData($cols,$where,$sort);

/*
 * Counting
 */
$countlist = array();
foreach($rows as $row) {
	$id = array_pop($row);
	$hhid = array_pop($row);
	if (!$hhid) { $hhid = $id; }
	if ($countlist[$hhid] < 1) {
		$countlist[$hhid] = 1;
	} else {
		$countlist[$hhid]++;
	}
}

if (($this->params_menu->get('show_header') == "1") && ($this->params_menu->get('display_empty') == "1")) {
	$this->header = array();
	for($i=0;$i<$Line;$i++) {
		$this->header[$i] = "";
		for($j=0;$j<$FieldPerLine;$j++) {
			$key = $i."_".$j;
			if (strlen($header[$key]) > 0) {
				if ($this->header[$i]) { $this->header[$i] .= " "; }
				$this->header[$i] .= $header[$key];
			}
		}
	}
}

/*
 * Calculate array
 */
$this->data = array();
if ($rows) {
	foreach($rows as $row) {
		$cpos=0;
		$id = array_pop($row);
		$hhid = array_pop($row);
		if (!$hhid) { $hhid = $id; }
		$name = array_pop($row);
		$salutation = array_pop($row);
		if ($hhid == $id) {
			if ($details) {
				$uri->setVar("id",$id);
			}
			$lines = array();
			for($i=0;$i<$Line;$i++) {
				for($j=0;$j<$FieldPerLine;$j++) {
					$key = $i."_".$j;
					if (strlen($pos[$key]) > 0) {
						if ($lines[$i]) { $lines[$i] .= " "; }
						$data = "";
						if ($countlist[$hhid] > 1) {
							if (($cols[$pos[$key]] == "salutation") && (trim($name)!= "")) {
								if ($salutation == "") {
									$salutation = " ";
								}
								$data = $salutation;
							}
							if (($cols[$pos[$key]] == "name") && (trim($name)!= "")) {
								$data = $name;
							}
							if (($cols[$pos[$key]] == "firstname") && (trim($name)!= "")) {
								$data = " ";
							}
							if (($cols[$pos[$key]] == "birthname") && (trim($name)!= "")) {
								$data = " ";
							}
						}
						if ($data == "") {
							$data = $row[$pos[$key]];
						} else {
							$data = trim($data);
						}
						$lines[$i] .= $data;
						$lines[$i] = trim($lines[$i]);
					}
				}
			}
			$datarow = array();
			for($i=0;$i<$Line;$i++) {
				if ((strlen($lines[$i]) > 0) || ($this->params_menu->get( "display_empty" ) == "1")) {
					$datarow[] = $lines[$i];
				}
			}
			$this->data[] = $datarow;
		}
	}
}
?>
