<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Membership
* @copyright	Copyright (c) 2012 Norbert Kümin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

defined('_JEXEC') or die('Restricted access'); // no direct access

function getparam ($cobj, $key) {
	return $cobj->params->get($key);
}

$uri = JFactory::getURI();
$id = intval($uri->getVar("id"));
if ($id == 0) {
}

/*
 * Get columns (person)
 */
$cols = array();
for ($i=1;$i<=10;$i++) {
	$field = "detail_column_".$i;
	if (getparam($this,$field) != "") {
		$cols[] = getparam($this,$field);
	}
}
$colcount = count($cols);
$cols[] = "id";
if (getparam($this,"detail_column_image") != "") {
	$cols[] = getparam($this,"detail_column_image");
}

/*
 * Calculate where (person)
 */
$where = "`".$this->cmobject->getSetting("Primary_Key")."`=".$id;

/*
 * Get data  (person)
 */
$label = getparam($this, 'detail_show_label' );
if ($label != "0") {
	$this->header = $this->cmobject->getViewHeader($cols);
}
$this->data = $this->cmobject->getViewData($cols,$where,"");
$row = $this->data[0];
if (getparam($this,"detail_column_image") != "") {
	$image = array_pop($row);
}
$person_id = array_pop($row);

/*
 * Display data  (person)
 */
if (getparam($this,"detail_css") != "") {
	echo "<style type=\"text/css\" media=\"screen\">\n".getparam($this,"detail_css")."\n</style>\n";
}
echo "<div class=\"cmdetail\"><table class=\"cmdetail_table\">\n";
for ($i=0;$i<$colcount;$i++) {
	echo "\t<tr class=\"cmdetail_row\">\n";
	if (($i == 0) && (getparam($this,"detail_column_image") != "")) {
		echo "\t\t<td class=\"cmdetail_imagefield\" rowspan=\"".$colcount."\"><img class=\"cmdetail_image\" src=\"".$this->params->get('image_dir').DS.$image."\"></td>\n";
	}
	if ($label != "0") {
		echo "\t\t<td class=\"cmdetail_field_title\"><span class=\"cmdetail_title\">".$this->header[$cols[$i]]." :</span></td>\n";
	}
	echo "\t\t<td class=\"cmdetail_field_data\"><span class=\"cmdetail_data\">".$row{$i}."</span></td>\n";
	echo "\t</tr>\n";
}
echo "</table></div>\n";

/*
 * Get columns (memberlist)
 */
$cols = array();
for ($i=1;$i<=5;$i++) {
	$field = "detail_member_column_".$i;
	if (getparam($this,$field) != "") {
		$cols[] = getparam($this,$field);
	}
}
$colcount = count($cols);

/*
 * Calculate where (memberlist)
 */
$where = "`person_id`=".$person_id;

/*
 * Get sort (memberlist)
 */
$sort = "";
for ($i=1;$i<=2;$i++) {
	$field1 = "detail_member_sort_column_".$i;
	$field2 = "detail_member_sort_direction_".$i;
	if (getparam($this,$field1) != "") {
		$sort .= ",`".getparam($this,$field1)."` ".getparam($this,$field2);
	}
}
if ($sort != "") $sort = substr($sort,1);

/*
 * Get data  (memberlist)
 */
require_once( JPATH_COMPONENT_ADMINISTRATOR.DS.'classes'.DS.'nokCMMembership.php');
$cmobject = new nokCMMembership("com_clubmanagement");
if ($colcount > 0) {
	if ($label != "0") {
		$this->header = $cmobject->getViewHeader($cols);
	}
	$this->data = $cmobject->getViewData($cols,$where,$sort);
} else {
	$this->data = array();
}
if (count($this->data) > 0) {
	//echo "<p>&nbsp;</p>\n";
	echo "<div class=\"cmdetail_member\">\n";
	if (getparam($this,"detail_member_title") != "") {
		echo "<span class=\"cmdetail_member_title\">".getparam($this,"detail_member_title")."</span>\n";
	}
	echo "<table class=\"cmdetail_member_table\">\n";
	if ($label != "0") {
		echo "<tr class=\"cmdetail_member_row_title\">";
		foreach($this->header as $strSingle) {
			if ($strSingle != "") {
				echo "<th class=\"cmdetail_member_field_title\">".$strSingle."</th>";
			}
		}
		echo "</tr>\n";
	}
	foreach($this->data as $row) {
		echo "<tr class=\"cmdetail_member_row_data\">\n";
		for($j=0;$j<$colcount;$j++) {
			echo "<td class=\"cmdetail_member_field_data\">";
			$field = $cmobject->_displayField($cols[$j], $row[$j]);
			echo $field;
			echo "</td>";
		}
		echo "</tr>\n";
	}
	echo "</table></div>\n";
}

/*
 * Get columns (boardlist)
 */
$cols = array();
for ($i=1;$i<=5;$i++) {
	$field = "detail_board_column_".$i;
	if (getparam($this,$field) != "") {
		$cols[] = getparam($this,$field);
	}
}
$colcount = count($cols);

/*
 * Calculate where (boardlist)
 */
$where = "`person_id`=".$person_id;

/*
 * Get sort (boardlist)
 */
$sort = "";
for ($i=1;$i<=2;$i++) {
	$field1 = "detail_board_sort_column_".$i;
	$field2 = "detail_board_sort_direction_".$i;
	if (getparam($this,$field1) != "") {
		$sort .= ",`".getparam($this,$field1)."` ".getparam($this,$field2);
	}
}
if ($sort != "") $sort = substr($sort,1);

/*
 * Get data  (boardlist)
 */
require_once( JPATH_COMPONENT_ADMINISTRATOR.DS.'classes'.DS.'nokCMBoard.php');
$cmobject = new nokCMBoard("com_clubmanagement");
if ($colcount > 0) {
	if ($label != "0") {
		$this->header = $cmobject->getViewHeader($cols);
	}
	$this->data = $cmobject->getViewData($cols,$where,$sort);
} else {
	$this->data = array();
}
if (count($this->data) > 0) {
	echo "<div class=\"cmdetail_board\">\n";
	if (getparam($this,"detail_board_title") != "") {
		echo "<span class=\"cmdetail_board_title\">".getparam($this,"detail_board_title")."</span>\n";
	}
	echo "<table class=\"cmdetail_board_table\">\n";
	if ($label != "0") {
		echo "<tr class=\"cmdetail_board_row_title\">";
		foreach($this->header as $strSingle) {
			if ($strSingle != "") {
				echo "<th class=\"cmdetail_board_field_title\">".$strSingle."</th>";
			}
		}
		echo "</tr>\n";
	}
	foreach($this->data as $row) {
		echo "<tr class=\"cmdetail_board_row_data\">\n";
		for($j=0;$j<$colcount;$j++) {
			echo "<td class=\"cmdetail_board_field_data\">";
			$field = $cmobject->_displayField($cols[$j], $row[$j]);
			echo $field;
			echo "</td>";
		}
		echo "</tr>\n";
	}
	echo "</table></div>\n";
}
?>
