<?php
/**
* @version		0.92
* @package		Joomla
* @subpackage	ClubManagement-Board
* @copyright	Copyright (c) 2009 Norbert Kümin. All rights reserved.
* @license		http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author		Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/
defined('_JEXEC') or die('Restricted access'); // no direct access

$details = false;
if ($this->params_menu->get( 'detail_enable' ) != "0")
{
	$details = true;
	$curi =& JFactory::getURI();
	$uri =& JURI::getInstance( $curi->toString() );
	$uri->setVar("layout","detail");
	$uri->setVar("tmpl","component");
	$uri->setVar("Itemid","");
	$uri->setVar("view","person");
}


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
if ($this->params_menu->get( 'boardstate' ) == "current")
{
	$where = "`end` IS NULL";
}
if ($this->params_menu->get( 'boardstate' ) == "closed")
{
	$where = "`end` IS NOT NULL";
}
if ($this->params_menu->get( 'publicity' ) == "published")
{
	if ($where != "") { $where = $where . " AND "; } 
	$where .= "`published`=1";
}
if ($this->params_menu->get( 'publicity' ) == "unpublished")
{
	if ($where != "") { $where = $where . " AND "; } 
	$where .= "`published`=0";
}

/*
 * Get data
 */
if ($this->params_menu->get( 'show_header' ) != "0")
{
	$this->header = $this->cmobject->getViewHeader($cols);
}
if ($details)
{
	$cols[] = "person_id";
}
$this->data = $this->cmobject->getViewData($cols,$where,$sort);

/*
 * Display
 */
if ($details)
{
	JHTML::_('behavior.modal');
}
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
if ($this->params->get('show_header', 1)) {
	echo "<tr>\n";
	foreach($this->header as $strSingle) {
		if ($strSingle != "")
		{
			echo "<th>".$strSingle."</th>";
		}
	}
	echo "</tr>\n";
}
if ($this->data)
{
	foreach($this->data as $row) {
		echo "<tr>\n";
		$i=0;
		if ($details)
		{
			$id = array_pop($row);
			$uri->setVar("id",$id);
		}
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
				$field = $this->cmobject->_displayField($cols[$j], $row[$i]);
				if ($details && (($this->params_menu->get( 'detail_column_link' ) == "") || ($this->params_menu->get( 'detail_column_link' ) == $cols[$j])))
				{
					echo "<a href=\"".$uri->toString()."\" class=\"modal\" rel=\"{handler: 'iframe', size: {x: ".$this->params->get( 'detail_width' ).", y: ".$this->params->get( 'detail_height' )."}}\">".$field."</a>";
				}
				else
				{
					echo $field;
				}
				echo "</td>";
				$i++;
			}
		}
		echo "</tr>\n";
	}
}
echo "</table>\n";
if ($this->params->get( "table_center") == "1") echo "</center>\n";
?>