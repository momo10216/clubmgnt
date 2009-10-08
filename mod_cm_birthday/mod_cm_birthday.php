<?php
/**
* @version		0.6
* @package		Joomla
* @subpackage	Module nok_cm_birthday
* @copyright	Copyright (c) 2009 Norbert Kümin. All rights reserved.
* @license		http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author		Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/
defined( '_JEXEC' ) or die( 'Restricted Access.' );

require_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_clubmanagement'.DS.'classes'.DS.'nokCMMembership.php');

// Initiaslize
$cmobject = new nokCMMembership("com_clubmanagement");
$today = date("Y-m-d");
$cmparams = &JComponentHelper::getParams( 'com_clubmanagement' );
$days = intval($params->get('days_before'));
$title_today = $params->get('title_today');
$title_next = $params->get('title_next');
$details = false;
if ($params->get( 'detail_enable' ) != "0")
{
	$details = true;
	$uri = JFactory::getURI();
	$uri->setVar("layout","detail");
	$uri->setVar("tmpl","component");
	$uri->setVar("Itemid","");
	$uri->setVar("option","com_clubmanagement");
	$uri->setVar("view","member");
	$uri->setVar("format","html");
}

// Get columns
$cols = array();
for ($i=1;$i<=4;$i++)
{
	$field = "column_".$i;
	if ($params->get( $field ) != "")
	{
		$cols[] = $params->get( $field );
	}
}
$colcount = count($cols);
$cols[] = "birthday";
$cols[] = $cmobject->getSetting("Primary_Key");

// Get today records
$calc_days = "DATEDIFF(#__nokCM_persons.`birthday` + INTERVAL YEAR('".$today."') - YEAR(#__nokCM_persons.`birthday`) + IF(DATE_FORMAT('".$today."', '%m%d') > DATE_FORMAT(birthday, '%m%d'), 1, 0) YEAR,'".$today."')";
$where_orig = "";
if ($params->get( 'memberstate' ) == "current")
{
	$where_orig = "`end` IS NULL";
}
if ($params->get( 'memberstate' ) == "closed")
{
	$where_orig = "`end` IS NOT NULL";
}
if ($params->get( 'membertype' ) != "*")
{
	if ($where_orig != "") { $where_orig .= " AND "; } 
	$where_orig .= "`type`='".$params->get( 'membertype' )."'";
}
if ($where_orig != "") { $where_orig .= " AND "; } 
$where_orig .= "`published`=1";
$where = $where_orig." AND ".$calc_days." = 0";
$data_today = $cmobject->getViewData($cols,$where,"");
if ($days > 0)
{
	$where = $where_orig." AND ".$calc_days." BETWEEN 1 AND ".$days;
	$data_next = $cmobject->getViewData($cols,$where,"");
}
else
{
	$data_next = array();
}

// Display
if ($details)
{
	JHTML::_('behavior.modal');
}
if ($params->get("css") != "")
{
	echo "<style type=\"text/css\" media=\"screen\">\n".$params->get("css")."\n</style>\n";
}
echo "<div class=\"cmbirth\">\n";
if (count($data_today) > 0)
{
	echo "\t<div class=\"cmbirth_today\">\n";
	if ($title_today != "")
	{
		echo "\t\t<div class=\"cmbirth_today_title\">".$title_today."</div>\n";
	}
	$name = array();
	foreach($data_today as $row)
	{
		$id = array_pop($row);
		$birthday = array_pop($row);
		$uri->setVar("id",$id);
		for($j=0;$j<$colcount;$j++)
		{
			$row[$j] = $cmobject->_displayField($cols[$j], $row[$j]);
			if ($details && ($params->get( 'detail_column_link' ) == $cols[$j]))
			{
				$row[$j] = "<a href=\"".$uri->toString()."\" class=\"modal\" rel=\"{handler: 'iframe', size: {x: ".$cmparams->get( 'detail_width' ).", y: ".$cmparams->get( 'detail_height' )."}}\">".$row[$j]."</a>";
			}
		}
		switch ($params->get('column_next'))
		{
			case "1": //(Weekday)
				$birthday = " <span class=\"cmbirth_today_person_birthday\">(".JText::_("Today").")</span>";
				break;
			case "2": //(month/day)
				//$birthday = " (".JHTML::_('date', $birthday, "???").")";
				$birthday = " <span class=\"cmbirth_today_person_birthday\">(".JText::_("Today").")</span>";
				break;
			case "3": //(day.month)
				//$birthday = " (".JHTML::_('date', $birthday, "???").")";
				$birthday = " <span class=\"cmbirth_today_person_birthday\">(".JText::_("Today").")</span>";
				break;
			default:
				$birthday = "";
				break;
		}
		if ($details && ($params->get( 'detail_column_link' ) == ""))
		{
			$name[] = "<a href=\"".$uri->toString()."\" class=\"modal\" rel=\"{handler: 'iframe', size: {x: ".$cmparams->get( 'detail_width' ).", y: ".$cmparams->get( 'detail_height' )."}}\">".implode(" ",$row)."</a>".$birthday;
		}
		else
		{
			$name[] = implode(" ",$row).$birthday;
		}
	}
	echo "\t\t<div class=\"cmbirth_today_person\">".implode($params->get('delimiter'),$name)."</div>\n";
	echo "\t</div>\n";
}
if (count($data_next) > 0)
{
	echo "\t<div class=\"cmbirth_next\">\n";
	if ($title_next != "")
	{
		echo "\t\t<div class=\"cmbirth_next_title\">".$title_next."</div>\n";
	}
	$name = array();
	foreach($data_next as $row)
	{
		$id = array_pop($row);
		$birthday = array_pop($row);
		$uri->setVar("id",$id);
		for($j=0;$j<$colcount;$j++)
		{
			$row[$j] = $cmobject->_displayField($cols[$j], $row[$j]);
			if ($details && ($params->get( 'detail_column_link' ) == $cols[$j]))
			{
				$row[$j] = "<a href=\"".$uri->toString()."\" class=\"modal\" rel=\"{handler: 'iframe', size: {x: ".$cmparams->get( 'detail_width' ).", y: ".$cmparams->get( 'detail_height' )."}}\">".$row[$j]."</a>";
			}
		}
		switch ($params->get('column_next'))
		{
			case "1": //(Weekday)
				$birthday = " <span class=\"cmbirth_today_person_birthday\">(".substr(JHTML::_('date', $birthday, "%a"),0,2).")</span>";
				break;
			case "2": //(month/day)
				$birthday = " <span class=\"cmbirth_today_person_birthday\">(".JHTML::_('date', $birthday, "%m/%d").")</span>";
				break;
			case "3": //(day.month)
				$birthday = " <span class=\"cmbirth_today_person_birthday\">(".JHTML::_('date', $birthday, "%d.%m").")</span>";
				break;
			default:
				$birthday = "";
				break;
		}
		if ($details && ($params->get( 'detail_column_link' ) == ""))
		{
			$name[] = "<a href=\"".$uri->toString()."\" class=\"modal\" rel=\"{handler: 'iframe', size: {x: ".$cmparams->get( 'detail_width' ).", y: ".$cmparams->get( 'detail_height' )."}}\">".implode(" ",$row)."</a>".$birthday;
		}
		else
		{
			$name[] = implode(" ",$row).$birthday;
		}
	}
	echo "\t\t<div class=\"cmbirth_today_person\">".implode($params->get('delimiter'),$name)."</div>\n";
	echo "\t</div>\n";
}
echo "</div>\n";
?>

