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

defined('_JEXEC') or die; // no direct access

$uri = JFactory::getURI();
$id = intval($uri->getVar("id"));
$model = $this->getModel();

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
/*
 * Get paramlist (person, membership and board)
 */
$personColumns = getParamList($this->paramsComponent, "detail_column_", 10);
$personColumnCount = count($personColumns);
$personColumnsHeader = $model->getPersonHeader($personColumns);
$memberColumns = getParamList($this->paramsComponent, "detail_member_column_", 5);
$memberColumnCount = count($memberColumns);
$memberColumnsHeader = $model->getMembershipHeader($memberColumns);
$boardColumns = getParamList($this->paramsComponent, "detail_board_column_", 5);
$boardColumnCount = count($boardColumns);
$boardColumnsHeader = $model->getBoardHeader($boardColumns);

/*
 * Display data  (person)
 */
$row = (array) $this->item;
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
if ($this->paramsComponent->get("detail_css") != "") {
	echo "<style type=\"text/css\" media=\"screen\">\n".$this->paramsComponent->get("detail_css")."\n</style>\n";
}
echo "<div class=\"cmdetail\"><table class=\"cmdetail_table\">\n";
$imageCol = $this->paramsComponent->get( "detail_column_image" );
$label = $this->paramsComponent->get( "detail_show_label" );
for ($i=0;$i<$personColumnCount;$i++) {
	$field = $personColumns[$i];
	echo "\t<tr class=\"cmdetail_row\">\n";
	if (($i == 0) && ($imageCol != "")) {
		$image = $row[$imageCol];
		echo "\t\t<td class=\"cmdetail_imagefield\" rowspan=\"".$personColumnCount."\"><img class=\"cmdetail_image\" src=\"".$imageDir.$image."\"></td>\n";
	}
	if ($label != "0") {
		echo "\t\t<td class=\"cmdetail_field_title\"><span class=\"cmdetail_title\">".$personColumnsHeader[$i]." :</span></td>\n";
	}
	echo "\t\t<td class=\"cmdetail_field_data\"><span class=\"cmdetail_data\">".$row{$field}."</span></td>\n";
	echo "\t</tr>\n";
}
echo "</table></div>\n";

/*
 * Get sort (memberlist)
 */
//die("<pre>".print_r($this->item)."</pre>");
$sort = "";
for ($i=1;$i<=2;$i++) {
	$field1 = "detail_member_sort_column_".$i;
	$field2 = "detail_member_sort_direction_".$i;
	if ($this->paramsComponent->get($field1) != "") {
		$sort .= ",`".$this->paramsComponent->get($field1)."` ".$this->paramsComponent->get($field2);
	}
}
if ($sort != "") $sort = substr($sort,1);

/*
 * Get data  (memberlist)
 */

JLoader::register('SelectionHelper', JPATH_COMPONENT_ADMINISTRATOR.'/helpers/selection.php', true);
if ($memberColumnCount > 0) {
	$memberTypes = SelectionHelper::getSelection("member_types");
	$data = $model->getMembershipItems($id,$sort);
	echo "<div class=\"cmdetail_member\">\n";
	if ($this->paramsComponent->get("detail_member_title") != "") {
		echo "<span class=\"cmdetail_member_title\">".$this->paramsComponent->get("detail_member_title")."</span>\n";
	}
	echo "<table class=\"cmdetail_member_table\">\n";
	if ($label != "0") {
		echo "<tr class=\"cmdetail_member_row_title\">";
		foreach($memberColumnsHeader as $strSingle) {
			if ($strSingle != "") {
				echo "<th class=\"cmdetail_member_field_title\">".$strSingle."</th>";
			}
		}
		echo "</tr>\n";
	}
	foreach($data as $item) {
		$row = (array) $item;
		echo "<tr class=\"cmdetail_member_row_data\">\n";
		for($j=0;$j<$memberColumnCount;$j++) {
			$field = $memberColumns[$j];
			echo "<td class=\"cmdetail_member_field_data\">";
			if (($field == "member_type") && !empty($memberTypes[$row[$field]])) {
				$data = $memberTypes[$row[$field]];
			} else {
				$data = $row[$field];
			}
			echo $data;
			echo "</td>";
		}
		echo "</tr>\n";
	}
	echo "</table></div>\n";
}

/*
 * Get sort (boardlist)
 */
$sort = "";
for ($i=1;$i<=2;$i++) {
	$field1 = "detail_board_sort_column_".$i;
	$field2 = "detail_board_sort_direction_".$i;
	if ($this->paramsComponent->get($field1) != "") {
		$sort .= ",`".$this->paramsComponent->get($field1)."` ".$this->paramsComponent->get($field2);
	}
}
if ($sort != "") $sort = substr($sort,1);

/*
 * Get data  (boardlist)
 */

if ($boardColumnCount > 0) {
	$boardJobs = SelectionHelper::getSelection("board_jobs");
	$data = $model->getBoardItems($id,$sort);
	echo "<div class=\"cmdetail_board\">\n";
	if ($this->paramsComponent->get("detail_board_title") != "") {
		echo "<span class=\"cmdetail_board_title\">".$this->paramsComponent->get("detail_board_title")."</span>\n";
	}
	echo "<table class=\"cmdetail_board_table\">\n";
	if ($label != "0") {
		echo "<tr class=\"cmdetail_board_row_title\">";
		foreach($boardColumnsHeader as $strSingle) {
			if ($strSingle != "") {
				echo "<th class=\"cmdetail_board_field_title\">".$strSingle."</th>";
			}
		}
		echo "</tr>\n";
	}
	foreach($data as $item) {
		$row = (array) $item;
		echo "<tr class=\"cmdetail_board_row_data\">\n";
		for($j=0;$j<$boardColumnCount;$j++) {
			echo "<td class=\"cmdetail_board_field_data\">";
			$field = $boardColumns[$j];
			if (($field == "board_job") && !empty($boardJobs[$row[$field]])) {
				$data = $boardJobs[$row[$field]];
			} else {
				$data = $row[$field];
			}
			echo $data;
			echo "</td>";
		}
		echo "</tr>\n";
	}
	echo "</table></div>\n";
}
?>
