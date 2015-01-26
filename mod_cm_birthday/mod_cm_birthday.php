<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	Module nok_cm_birthday
* @copyright	Copyright (c) 2014 Norbert Kümin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/
defined( '_JEXEC' ) or die;

function getBirthdayData($fields, $where, $order) {
	$fields[0] = "DISTINCT ".$fields[0]; //Ugly hack to eliminate duplicates
	$db = JFactory::getDBO();
	$query = $db->getQuery(true);
	$query->select($fields)
		->from($db->quoteName('#__nokCM_memberships','m'))
		->join('LEFT', $db->quoteName('#__nokCM_persons', 'p').' ON ('.$db->quoteName('m.person_id').'='.$db->quoteName('p.id').')')
		->where($where)
		->order($order);
	$db->setQuery($query);
	$data = $db->loadObjectList();
	return $data;
}

function displayBirthdays($items, $details, $cols, $colcount, $params, $cmparams, $uri, $bdtext="") {
	$name = array();
	foreach($items as $item) {
		$row = (array) $item;
		$birthday = array_pop($row);
		$id = array_pop($row);
		if ($details) {
			$uri->setVar("id",$id);
		}
		for($j=0;$j<$colcount;$j++) {
			if ($details && ($params->get( 'detail_column_link' ) == $cols[$j])) {
				$row[$j] = "<a href=\"".$uri->toString()."\" class=\"modal\" rel=\"{handler: 'iframe', size: {x: ".$cmparams->get( 'detail_width' ).", y: ".$cmparams->get( 'detail_height' )."}}\">".$row[$j]."</a>";
			}
		}
		if ($bdtext != "") {
			$birthday = " <span class=\"cmbirth_today_person_birthday\">(".$bdtext.")</span>";
		} else {
			switch ($params->get('column_next')) {
				case "1": //(Weekday)
					$birthday = " <span class=\"cmbirth_today_person_birthday\">(".JHTML::_('date', $birthday, "D").")</span>";
					break;
				case "2": //(month/day)
					$birthday = " <span class=\"cmbirth_today_person_birthday\">(".JHTML::_('date', $birthday, "m/d").")</span>";
					break;
				case "3": //(day.month)
					$birthday = " <span class=\"cmbirth_today_person_birthday\">(".JHTML::_('date', $birthday, "d.m").")</span>";
					break;
				default:
					$birthday = "";
					break;
			}
		}
		if ($details && ($params->get( 'detail_column_link' ) == "")) {
			$name[] = "<a href=\"".$uri->toString()."\" class=\"modal\" rel=\"{handler: 'iframe', size: {x: ".$cmparams->get( 'detail_width' ).", y: ".$cmparams->get( 'detail_height' )."}}\">".implode(" ",$row)."</a>".$birthday;
		} else {
			$name[] = implode(" ",$row).$birthday;
		}
	}
	return $name;
}

// Initialize
jimport('joomla.application.component.model');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_clubmanagement/models');
$memberModel = JModelLegacy::getInstance( 'Memberships', 'ClubManagementModel' );

$today = date("Y-m-d");
$cmparams = &JComponentHelper::getParams('com_clubmanagement');
$days = intval($params->get('days_before'));
$title_today = $params->get('title_today');
$title_next = $params->get('title_next');
$details = false;
if ($params->get('detail_enable') != "0")
{
	$details = true;
	$curi =& JFactory::getURI();
	$uri =& JURI::getInstance($curi->toString());
	$uri->setVar("layout","detail");
	$uri->setVar("tmpl","component");
	$uri->setVar("Itemid","");
	$uri->setVar("option","com_clubmanagement");
	$uri->setVar("view","person");
	$uri->setVar("format","html");
}

// Get columns
$cols = array();
for ($i=1;$i<=4;$i++)
{
	$field = "column_".$i;
	if ($params->get( $field ) != "")
	{
		$cols[] = $params->get($field);
	}
}
$colcount = count($cols);
$cols[] = "person_id";
$cols[] = "person_nextbirthday";
$fields = $memberModel->translateFieldsToColumns($cols,false);

// Get today records
$birthdateThisYear = "DATE_ADD(`p`.`birthday`, INTERVAL(YEAR(NOW()) - YEAR(`p`.`birthday`)) YEAR)";
$birthdateNextYear = "DATE_ADD(`p`.`birthday`, INTERVAL(YEAR(NOW()) - YEAR(`p`.`birthday`) + 1) YEAR)";
$next_birthday = "IF(".$birthdateThisYear." < CURDATE(), ".$birthdateNextYear.", ".$birthdateThisYear.")";
$calc_days = "DATEDIFF(".$next_birthday.",'".$today."')";
$order = $next_birthday." ASC";
$where_orig = "";
if ($params->get( 'memberstate' ) == "current") {
	$where_orig = "`m`.`end` IS NULL OR `m`.`end`='0000-00-00'";
}
if ($params->get( 'memberstate' ) == "closed") {
	$where_orig = "`m`.`end` IS NOT NULL AND NOT `m`.`end`='0000-00-00'";
}
if ($params->get( 'membertype' ) != "") {
	if ($where_orig != "") { $where_orig .= " AND "; } 
	$where_orig .= "`m`.`type`='".$params->get( 'membertype' )."'";
}
if ($params->get( 'publicity' ) == "published") {
	if ($where_orig != "") { $where_orig .= " AND "; } 
	$where_orig .= "`m`.`published`=1";
}
if ($params->get( 'publicity' ) == "unpublished") {
	if ($where_orig != "") { $where_orig .= " AND "; } 
	$where_orig .= "`m`.`published`=0";
}
$where = $where_orig." AND ".$calc_days." = 0";

$dataToday = getBirthdayData($fields, $where, $order);
if ($days > 0) {
	$where = $where_orig." AND ".$calc_days." BETWEEN 1 AND ".$days;
	$dataNext = getBirthdayData($fields, $where, $order);
} else {
	$dataNext = array();
}

// Display
if ($details) {
	JHTML::_('behavior.modal');
}
if ($params->get("css") != "") {
	echo "<style type=\"text/css\" media=\"screen\">\n".$params->get("css")."\n</style>\n";
}
echo "<div class=\"cmbirth\">\n";
if (count($dataToday) > 0) {
	echo "\t<div class=\"cmbirth_today\">\n";
	if ($title_today != "") {
		echo "\t\t<div class=\"cmbirth_today_title\">".$title_today."</div>\n";
	}
	$name = displayBirthdays($dataToday, $details, $cols, $colcount, $params, $cmparams, $uri, JText::_("Today"));
	echo "\t\t<div class=\"cmbirth_today_person\">".implode($params->get('delimiter'),$name)."</div>\n";
	echo "\t</div>\n";
}
if (count($dataNext) > 0) {
	echo "\t<div class=\"cmbirth_next\">\n";
	if ($title_next != "") {
		echo "\t\t<div class=\"cmbirth_next_title\">".$title_next."</div>\n";
	}
	$name = displayBirthdays($dataNext, $details, $cols, $colcount, $params, $cmparams, $uri);
	echo "\t\t<div class=\"cmbirth_today_person\">".implode($params->get('delimiter'),$name)."</div>\n";
	echo "\t</div>\n";
}
echo "</div>\n";
?>
