<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Board
* @copyright	Copyright (c) 2014 Norbert Kümin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/
defined('_JEXEC') or die; // no direct access

/*
 * Get columns
 */
$cols = array();
for ($i=1;$i<=20;$i++) {
	$field = "column_".$i;
	$col = $this->paramsMenuEntry->get($field);
	if (!empty($col)) {
		$cols[] = $this->paramsMenuEntry->get($field);
	}
}
$colcount = count($cols);

$this->header = $this->getModel()->getHeader($cols);
JLoader::register('SelectionHelper', JPATH_COMPONENT_ADMINISTRATOR.'/helpers/selection.php', true);
$boardJobs = SelectionHelper::getSelection("board_jobs");

/*
 * Prepare data
 */
foreach($this->items as $item) {
	$row = (array) $item;
	$newrow = array();
	for($j=0;$j<$colcount;$j++) {
		if ($cols[$j] != "") {
			$field = $cols[$j];
			if (($field == "board_job") && !empty($boardJobs[$row[$field]])) {
				$data = $boardJobs[$row[$field]];
			} else {
				$data = $row[$field];
			}
			array_push($newrow, $data);
		}
	}
	array_push($this->data, $newrow);
}
$this->filename = date('Y-m-d') . '_board_export' . '.csv';
?>
