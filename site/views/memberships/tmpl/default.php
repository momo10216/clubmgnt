<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Member
* @copyright	Copyright (c) 2014 Norbert Kümin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/
defined('_JEXEC') or die; // no direct access
JHTML::_( 'behavior.modal' );
$details = false;
if ($this->paramsMenuEntry->get('detail_enable') != "0") {
	$details = true;
	$curi = JFactory::getURI();
	$uri = JURI::getInstance( $curi->toString() );
	$uri->setVar("layout","detail");
	$uri->setVar("tmpl","component");
	$uri->setVar("Itemid","");
	$uri->setVar("view","person");
	$uri->setVar('option','com_clubmanagement');
	$detailWidth = $this->paramsComponent->get('detail_width');
	$detailHeight = $this->paramsComponent->get('detail_height');
}
// Get columns
$cols = array();
for ($i=1;$i<=20;$i++) {
	$field = "column_".$i;
	$cols[] = $this->paramsMenuEntry->get( $field );
}
$colcount = count($cols);
// Display
if ($details) {
	JHTML::_('behavior.modal');
}
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
	$header = $this->getModel()->getHeader($cols);
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
$detailColumn = $this->paramsMenuEntry->get('detail_column_link');
//echo "<pre>".$detailColumn."</pre>";
if ($this->items) {
	JLoader::register('SelectionHelper', JPATH_COMPONENT_ADMINISTRATOR.'/helpers/selection.php', true);
	$memberTypes = SelectionHelper::getSelection("member_types");
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
	foreach($this->items as $item) {
		$row = (array) $item;
		echo "<tr>\n";
		if ($details) {
			$id = $item->person_id;
			$uri->setVar('id',$id);
		}
		for($j=0;$j<$colcount;$j++) {
			$field = $cols[$j];
			if (!empty($field)) {
				if (($field == "member_type") && !empty($memberTypes[$row[$field]])) {
					$data = $memberTypes[$row[$field]];
				} else {
					$data = $row[$field];
				}
				if (strpos($field,'_image')) {
					$data = '<img src="'.$imageDir.$data.'" />';
				}
				echo "<td".$borderStyle.">";
				if ($details && (($detailColumn == "") || ($detailColumn == $field))) {
					echo "<a href=\"".$uri->toString()."\" class=\"modal\" rel=\"{handler: 'iframe', size: {x: ".$detailWidth.", y: ".$detailHeight."}}\">".$data."</a>";
				} else {
					echo $data;
				}
				echo "</td>";
			}
		}
		echo "</tr>\n";
	}
}
echo "</table>\n";
if ($this->paramsMenuEntry->get( "table_center") == "1") echo "</center>\n";
?>