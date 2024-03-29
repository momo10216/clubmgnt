<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Person
* @copyright	Copyright (c) 2014 Norbert Kuemin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

function getParamList($obj, $prefix, $amount) {
	$cols = array();
	for ($i=1;$i<=$amount;$i++) {
		$field = $prefix.$i;
		if ($obj->get($field) != "") {
			$cols[] = $obj->get($field);
		}
	}
	return $cols;
}

// Get paramlist (person, membership and board)
$model = $this->getModel();
$personColumns = getParamList($this->paramsComponent, 'detail_column_', 10);
$personColumnCount = count($personColumns);
$personColumnsHeader = $model->getPersonHeader($personColumns);
$memberColumns = getParamList($this->paramsComponent, 'detail_member_column_', 5);
$memberColumnCount = count($memberColumns);
$memberColumnsHeader = $model->getMembershipHeader($memberColumns);
$boardColumns = getParamList($this->paramsComponent, 'detail_board_column_', 5);
$boardColumnCount = count($boardColumns);
$boardColumnsHeader = $model->getBoardHeader($boardColumns);

// Display data  (person)
$row = (array) $this->item;
$id = $row['person_id'];
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
$cssText = '';
if ($this->iframe == '1') {
	$detailCss = $this->paramsComponent->get('detail_css');
	$detailColor = $this->paramsComponent->get('detail_color');
	$detailBackground = $this->paramsComponent->get('detail_background');
	$detailImageWidth = intval($this->paramsComponent->get('detail_image_width'));
	$cssText .= ".cmdetail_image {\n";
	$cssText .= "\tfloat: left;\n";
	if ($detailImageWidth > 0) {
		$cssText .= "\twidth: ".$detailImageWidth."px;\n";
		$cssText .= "\theight: auto;\n";
	}
	$cssText .= "}\n\n";
	if ($detailCss != '') {
		$cssText .= $detailCss."\n";
	}
	if (($detailColor != "") || ($detailBackground != '')) {
		$cssText .= ".cmdetail {\n";
		if ($detailColor != '') {
			$cssText .= "\tcolor: ".$detailColor.";\n";
		}
		if ($detailBackground != '') {
			$cssText .= "\tbackground-color: ".$detailBackground.";\n";
		}
		$cssText .= "}\n";
	}
} else {
	$cssText .= ".cmdetail_image {\n";
	$cssText .= "\tfloat: left;\n";
	$cssText .= "}\n\n";
}
$cssText .= ".tablerow label {\n";
$cssText .= "\twidth: 110px;\n";
$cssText .= "\tdisplay:block;\n";
$cssText .= "\tfloat: left;\n";
$cssText .= "\text-align: left;\n";
$cssText .= "}\n\n";
$cssText .= ".tablerow {\n";
$cssText .= "\toverflow: hidden;\n";
$cssText .= "}\n\n";
$cssText .= ".cmpersondetail_data {\n";
$cssText .= "\tmargin-left: 4px;\n";
$cssText .= "\tfloat: left;\n";
$cssText .= "}\n\n";
$doc = JFactory::getDocument();
$doc->addStyleDeclaration($cssText);
echo "\n<div class=\"cmdetail\">\n";
$imageCol = $this->paramsComponent->get("detail_column_image");
if ($imageCol != "") {
	$image = $row[$imageCol];
	echo "\t<img class=\"cmdetail_image\" src=\"".$imageDir.$image."\" />\n";
}
$label = $this->paramsComponent->get("detail_show_label");
echo "\t<div class=\"cmpersondetail\">\n";
for ($i=0;$i<$personColumnCount;$i++) {
	$field = $personColumns[$i];
	echo "\t\t<div class=\"tablerow\">";
	if ($label != "0") {
		echo "<label for=\"cmpersondetail_".$i."\">".$personColumnsHeader[$i]." :</label>";
	}
	echo "<span class=\"cmpersondetail_data\" id=\"cmpersondetail_".$i."\">".$row[$field]."</span></div>\n";
}
echo "\t</div>\n";
// Get sort (memberlist)
$sort = '';
for ($i=1;$i<=2;$i++) {
	$field1 = "detail_member_sort_column_".$i;
	$field2 = "detail_member_sort_direction_".$i;
	if ($this->paramsComponent->get($field1) != "") {
		$sort .= ",`".$this->paramsComponent->get($field1)."` ".$this->paramsComponent->get($field2);
	}
}
if ($sort != "") $sort = substr($sort,1);
// Get data  (memberlist)
JLoader::register('SelectionHelper', JPATH_COMPONENT_ADMINISTRATOR.'/helpers/selection.php', true);
if ($memberColumnCount > 0) {
	$memberTypes = SelectionHelper::getSelection("member_types");
	$data = $model->getMembershipItems($id,$sort);
	echo "\t<div class=\"cmdetail_member\">\n";
	if ($this->paramsComponent->get("detail_member_title") != "") {
		echo "\t\t<span class=\"cmdetail_member_title\">".$this->paramsComponent->get("detail_member_title")."</span>\n";
	}
	echo "\t\t<table class=\"cmdetail_member_table\">\n";
	if ($label != "0") {
		echo "\t\t\t<thead>\n";
		echo "\t\t\t\t<tr class=\"cmdetail_member_row_title\">";
		foreach($memberColumnsHeader as $strSingle) {
			if ($strSingle != "") {
				echo "<th class=\"cmdetail_member_field_title\">".$strSingle."</th>";
			}
		}
		echo "</tr>\n";
		echo "\t\t\t</thead>\n";
	}
	echo "\t\t\t<tbody>\n";
	foreach($data as $item) {
		$row = (array) $item;
		echo "\t\t\t\t<tr class=\"cmdetail_member_row_data\">\n";
		for($j=0;$j<$memberColumnCount;$j++) {
			$field = $memberColumns[$j];
			echo "\t\t\t\t\t<td class=\"cmdetail_member_field_data\">";
			if (($field == "member_type") && !empty($memberTypes[$row[$field]])) {
				$data = $memberTypes[$row[$field]];
			} else {
				$data = $row[$field];
			}
			echo $data;
			echo "</td>\n";
		}
		echo "\t\t\t\t</tr>\n";
	}
	echo "\t\t\t</tbody>\n";
	echo "\t\t</table>\n\t</div>\n";
}
// Get sort (boardlist)
$sort = '';
for ($i=1;$i<=2;$i++) {
	$field1 = "detail_board_sort_column_".$i;
	$field2 = "detail_board_sort_direction_".$i;
	if ($this->paramsComponent->get($field1) != "") {
		$sort .= ",`".$this->paramsComponent->get($field1)."` ".$this->paramsComponent->get($field2);
	}
}
if ($sort != "") $sort = substr($sort,1);
// Get data  (boardlist)
if ($boardColumnCount > 0) {
	$boardJobs = SelectionHelper::getSelection("board_jobs");
	$data = $model->getBoardItems($id,$sort);
	echo "\t<div class=\"cmdetail_board\">\n";
	if ($this->paramsComponent->get("detail_board_title") != "") {
		echo "\t\t<span class=\"cmdetail_board_title\">".$this->paramsComponent->get("detail_board_title")."</span>\n";
	}
	echo "\t\t<table class=\"cmdetail_board_table\">\n";
	if ($label != "0") {
		echo "\t\t\t<thead>\n";
		echo "\t\t\t\t<tr class=\"cmdetail_board_row_title\">";
		foreach($boardColumnsHeader as $strSingle) {
			if ($strSingle != "") {
				echo "<th class=\"cmdetail_board_field_title\">".$strSingle."</th>";
			}
		}
		echo "</tr>\n";
		echo "\t\t\t</thead>\n";
	}
	echo "\t\t\t<tbody>\n";
	foreach($data as $item) {
		$row = (array) $item;
		echo "\t\t\t\t<tr class=\"cmdetail_board_row_data\">\n";
		for($j=0;$j<$boardColumnCount;$j++) {
			echo "\t\t\t\t\t<td class=\"cmdetail_board_field_data\">";
			$field = $boardColumns[$j];
			if (($field == "board_job") && !empty($boardJobs[$row[$field]])) {
				$data = $boardJobs[$row[$field]];
			} else {
				$data = $row[$field];
			}
			echo $data;
			echo "</td>\n";
		}
		echo "\t\t\t\t</tr>\n";
	}
	echo "\t\t\t</tbody>\n";
	echo "\t\t</table>\n\t</div>\n";
}
echo "</div>\n";
?>
