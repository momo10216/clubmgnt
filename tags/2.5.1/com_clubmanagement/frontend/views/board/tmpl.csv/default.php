<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Board
* @copyright	Copyright (c) 2012 Norbert K�min. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/
defined('_JEXEC') or die('Restricted access'); // no direct access

/*
 * Get columns
 */
$cols = array();
for ($i=1;$i<=20;$i++) {
	$field = "column_".$i;
	$cols[] = $this->params_menu->get($field);
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
$where = "";
if ($this->params_menu->get( 'boardstate' ) == "current") {
	$where = "`end` IS NULL";
}
if ($this->params_menu->get( 'boardstate' ) == "closed") {
	$where = "`end` IS NOT NULL";
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
$this->data = $this->cmobject->getViewData($cols,$where,$sort);

//JToolBarHelper::back();
$this->filename = date('Y-m-d') . '_board_export' . '.csv';
if ($this->params_menu->get( 'show_header' ) != "0") {
	$this->header = $this->cmobject->getViewHeader($cols);
}

?>