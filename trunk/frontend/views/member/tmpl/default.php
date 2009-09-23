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
$colcount = count($cols);

/*
 * Get sort
 */
$sort = "";
for ($i=1;$i<=4;$i++)
{
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
if ($where != "") { $where = $where . " AND "; } 
$where = $where . "`published`=1";

/*
 * Get data
 */
if ($this->params_menu->get( 'show_header' ) != "0")
{
	$this->header = $this->cmobject->getViewHeader($cols);
}
$this->data = $this->cmobject->getViewData($cols,$where,$sort);
$border="border-style:solid; border-width:1px";
$width="";
if ($this->params_menu->get( 'width' ) != "0")
{
	$width="width=\"".$this->params_menu->get( 'width' )."\" ";
}

if ($this->params->get( "table_center") == "1") echo "<center>\n";
if ($this->params->get( "border_type") != "")
{
	echo "<table ".$width."border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"".$border."\">\n";
}
else
{
	echo "<table ".$width."border=\"0\" style=\"border-style:none; border-width:0px\">\n";
}
if ($this->params->get('show_header', 1))
{
	echo "<tr>";
	foreach($this->header as $strSingle)
	{
		if ($strSingle != "")
		{
			echo "<th>".$strSingle."</th>";
		}
	}
	echo "</tr>\n";
}
foreach($this->data as $row)
{
	echo "<tr>\n";
	$i=0;
	for($j=0;$j<$colcount;$j++)
	{
		if ($cols[$j] != "")
		{
			switch ($this->params_menu->get( "border_type"))
			{
				case "row":
					echo "<td style=\"border-top-style:solid; border-width:1px\">";
					break;
				case "grid":
					echo "<td style=\"".$border."\">";
					break;
				default:
					echo "<td>";
					break;
			}
			echo $this->cmobject->_displayField($cols[$j], $row[$i])."</td>";
			$i++;
		}
	}
	echo "</tr>\n";
}
echo "</table>\n";
if ($this->params->get( "table_center") == "1") echo "</center>\n";
?>