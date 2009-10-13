<?php
/**
* @version		0.5
* @package		Joomla
* @subpackage	ClubManagement-Membership
* @copyright	Copyright (c) 2009 Norbert Kümin. All rights reserved.
* @license		http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author		Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

defined('_JEXEC') or die('Restricted access'); // no direct access

/*
 * Get columns
 */
$cols = array();
for ($i=1;$i<=20;$i++)
{
	$field = "column_".$i;
	$cols[] = $this->params_menu->get( $field );
}

/*
 * Calculate where
 */
$where = "";
if ($this->params_menu->get( 'memberstate' ) == "current")
{
	$where = "`end` IS NULL";
}
if ($this->params_menu->get( 'memberstate' ) == "closed")
{
	$where = "`end` IS NOT NULL";
}
if ($this->params_menu->get( 'membertype' ) != "*")
{
	if ($where != "") { $where = $where . " AND "; } 
	$where = $where . "`type`='".$this->params_menu->get( 'membertype' )."'";
}

/*
 * Get data
 */
$this->data = $cmobject->getViewData($cols,$where,"`name`,`firstname`");
$this->filename = date('Y-m-d') . '_export' . '.csv';
if ($this->params_menu->get( 'show_header' ) != "0") {
	$this->header = $cmobject->getViewHeader($cols);
}

?>