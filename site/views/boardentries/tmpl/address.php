<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Board
* @copyright	Copyright (c) 2012 Norbert KUEmin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

$FieldPerLine=4;
$Line=5;
$details = false;
if ($this->paramsMenuEntry->get( 'detail_enable' ) != "0") {
	JHtml::_('behavior.modal');
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
for ($i=1;$i<=20;$i++) {
	$field = "column_".$i;
	$cols[] = $this->paramsMenuEntry->get($field);
}
$colcount = count($cols);

/*
 * Display
 */
if ($this->paramsMenuEntry->get( "table_center") == "1") echo "<center>\n";
if ($this->paramsMenuEntry->get( "border_type") != "") {
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"".$border."\">\n";
} else {
	echo "<table border=\"0\" style=\"border-style:none; border-width:0px\">\n";
}
if (($this->paramsMenuEntry->get('show_header') == "1") && ($this->paramsMenuEntry->get('display_empty') == "1")) {
	$header = $this->getModel()->getHeader($cols);
	echo "<tr>";
	for($i=0;$i<$Line;$i++) {
		$headerFields = array();
		for($j=0;$j<$FieldPerLine;$j++) {
			$colnr = $i*$FieldPerLine+$j;
			if (isset($header[$colnr])) {
				array_push($headerFields,$header[$colnr]);
			}
		}
		echo "<th>".implode(' ',$headerFields)."</th>";
	}
	echo "</tr>\n";
}
if ($this->items) {
	JLoader::register('SelectionHelper', JPATH_COMPONENT_ADMINISTRATOR.'/helpers/selection.php', true);
	$boardJobs = SelectionHelper::getSelection("board_jobs");
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
	$lastLines = array();
	foreach($this->items as $item) {
		$row = (array) $item;
		if (empty($item->person_hh_person_id)) {
			if ($details) {
				$uri->setVar("id",$item->person_id);
			}
			$lines = array();
			for($i=0;$i<$Line;$i++) {
				$lines[$i] = '';
				for($j=0;$j<$FieldPerLine;$j++) {
					$colnr = $i*$FieldPerLine+$j;
					$field = $cols[$colnr];
					$data = '';
					if (($field == "board_job") && !empty($boardJobs[$row[$field]])) {
						$data = $boardJobs[$row[$field]];
					} else {
						if (isset($row[$field])) { $data = $row[$field]; }
					}

					if (strlen($data) > 0) {
						if ($lines[$i]) { $lines[$i] .= " "; }
						if ($details && ($this->paramsMenuEntry->get( 'detail_column_link' ) == $field) && ($data != "")) {
							$data = "<a href=\"".$uri->toString()."\" class=\"modal\" rel=\"{handler: 'iframe', size: {x: ".$this->paramsMenuComponent->get( 'detail_width' ).", y: ".$this->paramsComponent->get( 'detail_height' )."}}\">".$data."</a>";
						}
						$lines[$i] .= $data;
						$lines[$i] = trim($lines[$i]);
					}
				}
				if ($details && ($this->paramsMenuEntry->get( 'detail_column_link' ) == "") && ($data != "")) {
					$lines[$i] = "<a href=\"".$uri->toString()."\" class=\"modal\" rel=\"{handler: 'iframe', size: {x: ".$this->paramsComponent->get( 'detail_width' ).", y: ".$this->paramsComponent->get( 'detail_height' )."}}\">".$lines[$i]."</a>";
				}
			}
			if ($lastLines != $lines) {
				echo "<tr valign=\"top\">\n";
				for($i=0;$i<$Line;$i++) {
					if ((strlen($lines[$i]) > 0) || ($this->paramsMenuEntry->get( "display_empty" ) == "1")) {
						echo "<td align=\"".$this->paramsMenuEntry->get( "textalign" )."\">";
						echo $lines[$i]."<br />\n";
						echo "</td>\n";
					}
				}
				echo "</tr>\n";
				$lastLines = $lines;
			}
		}
	}
}
echo "</table>\n";
if ($this->paramsMenuEntry->get( "table_center") == "1") echo "</center>\n";
?>
