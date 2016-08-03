<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Board
* @copyright	Copyright (c) 2012 Norbert Kümin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

defined('_JEXEC') or die; // no direct access
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
if ($this->paramsMenuEntry->get( "table_center") == "1") echo "<center>\n";
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
	foreach($this->items as $item) {
		$row = (array) $item;
		$lines = array();
		$imageCol = $this->paramsMenuEntry->get( "column_image" );
		if ($imageCol != "") {
			$image = $row[$imageCol];
		}
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
		echo "<table".$borderStyle.">\n";
		switch ($this->paramsMenuEntry->get( "picpos" )) {
			case "right": //picture on the left side
				echo "<tr valign=\"top\">\n";
				echo "<td align=\"".$this->paramsMenuEntry->get( "textalign" )."\">";
				for($i=0;$i<$Line;$i++) {
					if (strlen($lines[$i]) > 0) {
						echo $lines[$i]."<br />\n";
					}
				}
				echo "</td>\n";
				if ($image) {
					echo "<td align=\"".$this->paramsMenuEntry->get( "textalign" )."\"><img src=\"".$imageDir.$image."\" width=\"".$this->paramsMenuEntry->get('image_size')."\"></td>\n";
				}
				echo "</tr>\n";
				break;
			case "top": //picture on the left side
				echo "<tr valign=\"top\">\n";
				if ($image) {
					echo "<td align=\"".$this->paramsMenuEntry->get( "textalign" )."\"><img src=\"".$imageDir.$image."\" width=\"".$this->paramsMenuEntry->get('image_size')."\"></td>\n";
				}
				echo "</tr>\n";
				echo "<tr valign=\"top\">\n";
				echo "<td align=\"".$this->paramsMenuEntry->get( "textalign" )."\">";
				for($i=0;$i<$Line;$i++) {
					if (strlen($lines[$i]) > 0) {
						echo $lines[$i]."<br />\n";
					}
				}
				echo "</td>\n";
				echo "</tr>\n";
				break;
			case "bottom": //picture on the left side
				echo "<tr valign=\"top\">\n";
				echo "<td align=\"".$this->paramsMenuEntry->get( "textalign" )."\">";
				for($i=0;$i<$Line;$i++) {
					if (strlen($lines[$i]) > 0) {
						echo $lines[$i]."<br />\n";
					}
				}
				echo "</td>\n";
				echo "</tr>\n";
				echo "<tr valign=\"top\">\n";
				if ($image) {
					echo "<td align=\"".$this->paramsMenuEntry->get( "textalign" )."\"><img src=\"".$imageDir.$image."\" width=\"".$this->paramsMenuEntry->get('image_size')."\"></td>\n";
				}
				echo "</tr>\n";
				break;
			case "left": //picture on the left side
			default:
				echo "<tr valign=\"top\">\n";
				if ($image) {
					echo "<td align=\"".$this->paramsMenuEntry->get( "textalign" )."\"><img src=\"".$imageDir.$image."\" width=\"".$this->paramsMenuEntry->get('image_size')."\"></td>\n";
				}
				echo "<td align=\"".$this->paramsMenuEntry->get( "textalign" )."\">";
				for($i=0;$i<$Line;$i++) {
					if (strlen($lines[$i]) > 0) {
						echo $lines[$i]."<br />\n";
					}
				}
				echo "</td>\n";
				echo "</tr>\n";
				break;
		}
		echo "</table>\n";
		echo "<p/>\n";
	}
}
if ($this->paramsMenuEntry->get( "table_center") == "1") echo "</center>\n";
?>
