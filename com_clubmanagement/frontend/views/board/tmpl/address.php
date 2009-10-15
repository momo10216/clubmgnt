<?php
/**
* @version		0.5
* @package		Joomla
* @subpackage	ClubManagement-Board
* @copyright	Copyright (c) 2009 Norbert Kümin. All rights reserved.
* @license		http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author		Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

defined('_JEXEC') or die('Restricted access'); // no direct access
$FieldPerLine=4;
$Line=5;
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
$pos = array();
for ($i=1;$i<=20;$i++)
{
	$field = "column_".$i;
	if ($this->params_menu->get( $field ) != "") {
		$key = intval(($i-1)/$FieldPerLine)."_".bcmod(($i-1),$FieldPerLine);
		$cols[] = $this->params_menu->get( $field );
		$pos[$key] = count($cols)-1;
	}
}

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
//$where = "`hh_person_id` IS NULL";
$where = "`published`=1";
if ($this->params_menu->get( 'boardstate' ) == "current")
{
	$where .= " AND `end` IS NULL";
}
if ($this->params_menu->get( 'boardstate' ) == "closed")
{
	$where .= " AND `end` IS NOT NULL";
}

/*
 * Get data
 */
$cols[] = "hh_salutation_override";
$cols[] = "hh_name_override";
$cols[] = "hh_person_id";
$cols[] = "person_id";
$this->data = $this->cmobject->getViewData($cols,$where,$sort);
if (($this->params->get('show_header') == "1") && ($this->params->get('display_empty') == "1"))
{
	$this->header = $this->cmobject->getViewHeader($cols);
}

/*
 * Counting
 */
$countlist = array();
foreach($this->data as $row)
{
	$id = array_pop($row);
	$hhid = array_pop($row);
	if (!$hhid) { $hhid = $id; }
	if ($countlist[$hhid] < 1)
	{
		$countlist[$hhid] = 1;
	}
	else
	{
		$countlist[$hhid]++;
	}
}

/*
 * Display
 */
if ($details)
{
	JHTML::_('behavior.modal');
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
if (($this->params->get('show_header') == "1") && ($this->params->get('display_empty') == "1"))
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
	$cpos=0;
	$id = array_pop($row);
	$hhid = array_pop($row);
	if (!$hhid) { $hhid = $id; }
	$name = array_pop($row);
	$salutation = array_pop($row);
	if ($hhid == $id)
	{
		if ($details)
		{
			$uri->setVar("id",$id);
		}
		$lines = array();
		for($i=0;$i<$Line;$i++) {
			for($j=0;$j<$FieldPerLine;$j++) {
				$key = $i."_".$j;
				if (strlen($pos[$key]) > 0) {
					if ($lines[$i]) { $lines[$i] .= " "; }
					$data = "";
					if ($countlist[$hhid] > 1)
					{
						if (($cols[$pos[$key]] == "salutation") && (trim($name)!= ""))
						{
							if ($salutation == "")
							{
								$salutation = " ";
							}
							$data = $salutation;
						}
						if (($cols[$pos[$key]] == "name") && (trim($name)!= ""))
						{
							$data = $name;
						}
						if (($cols[$pos[$key]] == "firstname") && (trim($name)!= ""))
						{
							$data = " ";
						}
						if (($cols[$pos[$key]] == "birthname") && (trim($name)!= ""))
						{
							$data = " ";
						}
					}
					if ($data == "")
					{
						$data = $this->cmobject->_displayField($cols[$pos[$key]], $row[$pos[$key]]);
					}
					else
					{
						$data = trim($data);
					}
					if ($details && ($this->params_menu->get( 'detail_column_link' ) == $cols[$pos[$key]]) && ($data != ""))
					{
						$data = "<a href=\"".$uri->toString()."\" class=\"modal\" rel=\"{handler: 'iframe', size: {x: ".$this->params->get( 'detail_width' ).", y: ".$this->params->get( 'detail_height' )."}}\">".$data."</a>";
					}
					$lines[$i] .= $data;
					$lines[$i] = trim($lines[$i]);
				}
			}
			if ($details && ($this->params_menu->get( 'detail_column_link' ) == "") && ($data != ""))
			{
				$lines[$i] = "<a href=\"".$uri->toString()."\" class=\"modal\" rel=\"{handler: 'iframe', size: {x: ".$this->params->get( 'detail_width' ).", y: ".$this->params->get( 'detail_height' )."}}\">".$lines[$i]."</a>";
			}
		}
		echo "<tr valign=\"top\">\n";
		for($i=0;$i<$Line;$i++) {
			if ((strlen($lines[$i]) > 0) || ($this->params_menu->get( "display_empty" ) == "1"))
			{
				echo "<td align=\"".$this->params_menu->get( "textalign" )."\">";
				echo $lines[$i]."<br />\n";
				echo "</td>\n";
			}
		}
		echo "</tr>\n";
	}
}
echo "</table>\n";
if ($this->params->get( "card_center") == "1") echo "</center>\n";
?>
