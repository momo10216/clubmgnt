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
$FieldPerLine=4;
$Line=5;

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
$where = "`deceased` IS NULL";
if ($this->params_menu->get( 'memberstate' ) == "current")
{
	$where .= " AND `end` IS NULL";
}
if ($this->params_menu->get( 'memberstate' ) == "closed")
{
	$where .= " AND `end` IS NOT NULL";
}
if ($this->params_menu->get( 'membertype' ) != "*")
{
	$where .= " AND `type`='".$this->params_menu->get( 'membertype' )."'";
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
if (($this->params->get('show_header') == "1") && ($this->params->get('display_empty') == "1"))
{
	$this->header = $this->cmobject->getViewHeader($cols);
}
$this->filename = date('Y-m-d') . '_member_address' . '.csv';
$cols[] = "hh_salutation_override";
$cols[] = "hh_name_override";
$cols[] = "hh_person_id";
$cols[] = "person_id";
$rows = $cmobject->getViewData($cols,$where,$sort);

/*
 * Counting
 */
$countlist = array();
foreach($rows as $row)
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
 * Calculate array
 */
$this->data = array();
if ($rows)
{
	foreach($rows as $row)
	{
		$cpos=0;
		$id = array_pop($row);
		$hhid = array_pop($row);
		if (!$hhid) { $hhid = $id; }
		$name = array_pop($row);
		$salutation = array_pop($row);
		if ($hhid == $id)
		{
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
							//$data = $this->cmobject->_displayField($cols[$pos[$key]], $row[$pos[$key]]);
							$data = $row[$pos[$key]];
						}
						else
						{
							$data = trim($data);
						}
						$lines[$i] .= $data;
						$lines[$i] = trim($lines[$i]);
					}
				}
			}
			$datarow = array();
			for($i=0;$i<$Line;$i++) {
				if ((strlen($lines[$i]) > 0) || ($this->params_menu->get( "display_empty" ) == "1"))
				{
					$datarow[] = $lines[$i];
				}
			}
			$this->data[] = $datarow;
		}
	}
}
?>