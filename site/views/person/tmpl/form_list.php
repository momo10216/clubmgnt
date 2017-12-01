<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Person
* @copyright	Copyright (c) 2014 Norbert Kümin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Get columns
$cols = array();
for ($i=1;$i<=10;$i++) {
	$field = "column_".$i;
	$col = $this->paramsMenuEntry->get($field);
	if (!empty($col)) {
		$cols[] = $col;
	}
}
$colcount = count($cols);
// Get sort columns
$sort = array();
for ($i=1;$i<=2;$i++) {
	$fieldSortCol = "sort_column_".$i;
	$fieldSortOrder = "sort_direction_".$i;
	$sort[] = $this->paramsMenuEntry->get($fieldSortCol)." ".$this->paramsMenuEntry->get($fieldSortOrder);
}
$sortcount = count($sort);
// Display
$border="border-style:solid; border-width:1px";
$width="";
if ($this->paramsComponent->get('width') != "0") {
	$width="width=\"".$this->paramsComponent->get( 'width' )."\" ";
}
if ($this->paramsMenuEntry->get( "table_center") == "1") echo "<center>\n";
if ($this->paramsMenuEntry->get( "border_type") != "") {
	echo "<table ".$width."border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"".$border."\">\n";
} else {
	echo "<table ".$width."border=\"0\" style=\"border-style:none; border-width:0px\">\n";
}
if ($this->paramsMenuEntry->get('show_header', '1') == '1') {
	$header = $this->getModel()->getPersonHeader($cols);
	echo "<tr>";
	foreach($header as $strSingle) {
		if ($strSingle != "") {
			echo "<th>".$strSingle."</th>";
		}
	}
	echo "</tr>\n";
}
$imageDir = $this->paramsComponent->get('image_dir');
if (!empty($imageDir)) {
	if (substr($imageDir,-1) != DIRECTORY_SEPARATOR) {
		$imageDir = $imageDir.DIRECTORY_SEPARATOR;
	}
	if (substr(JURI::root(),-1) == DIRECTORY_SEPARATOR) {
		if (substr($imageDir,0,1) == DIRECTORY_SEPARATOR) {
			$imageDir = JURI::root().substr($imageDir,1);
		} else {
			$imageDir = JURI::root().$imageDir;
		}
	} else {
		if (substr($imageDir,0,1) == DIRECTORY_SEPARATOR) {
			$imageDir = JURI::root().$imageDir;
		} else {
			$imageDir = JURI::root().DIRECTORY_SEPARATOR.$imageDir;
		}
	}
}
//echo "<pre>".$detailColumn."</pre>";
$items = $this->getModel()->getPersonItemsForCurrentUser($cols,$sort);
if ($items) {
	switch ($this->paramsMenuEntry->get( "border_type")) {
		case "row":
			$borderStyle = " style=\"border-top-style:solid; border-width:1px\"";
			break;
		case "grid":
			$borderStyle = " style=\"".$border."\"";
			break;
		default:
			$borderStyle = "";
			break;
	}
	$url = JRoute::_('index.php?option=com_clubmanagement&layout='.$this->getLayout().'&id=');
	foreach($items as $item) {
		$row = (array) $item;
		echo "<tr>\n";
		for($j=0;$j<$colcount;$j++) {
			$field = $cols[$j];
			if (!empty($field)) {
				$data = $row[$field];
				if (strpos($field,'_image')) {
					$data = '<img src="'.$imageDir.$data.'" />';
				}
				echo "<td".$borderStyle.">";
				echo "<a href=\"".$url.$item->person_id."\">".$data."</a>";
				echo "</td>";
			}
		}
		echo "</tr>\n";
	}
}
echo "</table>\n";
if ($this->paramsMenuEntry->get( "table_center") == "1") echo "</center>\n";
?>
