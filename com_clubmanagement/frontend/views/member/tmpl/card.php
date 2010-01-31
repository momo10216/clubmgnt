<?php
/**
* @version		0.5
* @package		Joomla
* @subpackage	ClubManagement-Board
* @copyright	Copyright (c) 2009 Norbert Kümin. All rights reserved.
* @license		http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author		Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

defined('_JEXEC') or die('Restricted access'); // no direct access
$FieldPerLine=4;
$Line=5;
$details = false;
if ($this->params_menu->get( 'detail_enable' ) != "0")
{
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
$pos = array();
if ($this->params_menu->get( "column_image" ) != "") {
	$cols[] = $this->params_menu->get( "column_image" );
}
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
$where = "";
if ($this->params_menu->get( 'memberstate' ) == "current")
{
	$where = "`end` IS NULL";
}
if ($this->params_menu->get( 'memberstate' ) == "closed")
{
	$where = "`end` IS NOT NULL";
}
if ($this->params_menu->get( 'membertype' ) != "*")
{
	if ($where != "") { $where = $where . " AND "; } 
	$where = $where . "`type`='".$this->params_menu->get( 'membertype' )."'";
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
if ($details)
{
	$cols[] = "person_id";
}
$this->data = $this->cmobject->getViewData($cols,$where,$sort);

/*
 * Display
 */
if ($details)
{
	JHTML::_('behavior.modal');
}
if ($this->params->get( "card_center") == "1") echo "<center>\n";
if ($this->data)
{
	foreach($this->data as $row) {
		$cpos=0;
		if ($details)
		{
			$id = array_pop($row);
			$uri->setVar("id",$id);
		}
		if ($this->params_menu->get( "column_image" ) != "") {
			$image = $row[$cpos];
		}
		$lines = array();
		for($i=0;$i<$Line;$i++) {
			for($j=0;$j<$FieldPerLine;$j++) {
				$key = $i."_".$j;
				if (strlen($pos[$key]) > 0) {
					if ($lines[$i]) { $lines[$i] .= " "; }
					$data = $this->cmobject->_displayField($cols[$pos[$key]], $row[$pos[$key]]);
					if ($details && (($this->params_menu->get( 'detail_column_link' ) == "") || ($this->params_menu->get( 'detail_column_link' ) == $cols[$pos[$key]])))
					{
						$data = "<a href=\"".$uri->toString()."\" class=\"modal\" rel=\"{handler: 'iframe', size: {x: ".$this->params->get( 'detail_width' ).", y: ".$this->params->get( 'detail_height' )."}}\">".$data."</a>";
					}
					$lines[$i] .= $data;
				}
			}
		}
		switch ($this->params_menu->get( "border" ))
		{
			case "normal": //standard border
				echo "<table border=\"1\">\n";
				break;
			case "line": //standard border
				echo "<table border=\"0\" style=\"border-style:solid; border-width:1px\">\n";
				break;
			default: //no border
				echo "<table>\n";
				break;
		}
		switch ($this->params_menu->get( "picpos" ))
		{
			case "right": //picture on the left side
				echo "<tr valign=\"top\">\n";
				echo "<td align=\"".$this->params_menu->get( "textalign" )."\">";
				for($i=0;$i<$Line;$i++) {
					if (strlen($lines[$i]) > 0) {
						echo $lines[$i]."<br />\n";
					}
				}
				echo "</td>\n";
				if ($image) {
					echo "<td align=\"".$this->params_menu->get( "textalign" )."\"><img src=\"".$this->params->get('image_dir').DS.$image."\" width=\"".$this->params->get('image_size')."\"></td>\n";
				}
				echo "</tr>\n";
				break;
			case "top": //picture on the left side
				echo "<tr valign=\"top\">\n";
				if ($image) {
					echo "<td align=\"".$this->params_menu->get( "textalign" )."\"><img src=\"".$this->params->get('image_dir').DS.$image."\" width=\"".$this->params->get('image_size')."\"></td>\n";
				}
				echo "</tr>\n";
				echo "<tr valign=\"top\">\n";
				echo "<td align=\"".$this->params_menu->get( "textalign" )."\">";
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
				echo "<td align=\"".$this->params_menu->get( "textalign" )."\">";
				for($i=0;$i<$Line;$i++) {
					if (strlen($lines[$i]) > 0) {
						echo $lines[$i]."<br />\n";
					}
				}
				echo "</td>\n";
				echo "</tr>\n";
				echo "<tr valign=\"top\">\n";
				if ($image) {
					echo "<td align=\"".$this->params_menu->get( "textalign" )."\"><img src=\"".$this->params->get('image_dir').DS.$image."\" width=\"".$this->params->get('image_size')."\"></td>\n";
				}
				echo "</tr>\n";
				break;
			case "left": //picture on the left side
			default:
				echo "<tr valign=\"top\">\n";
				if ($image) {
					echo "<td align=\"".$this->params_menu->get( "textalign" )."\"><img src=\"".$this->params->get('image_dir').DS.$image."\" width=\"".$this->params->get('image_size')."\"></td>\n";
				}
				echo "<td align=\"".$this->params_menu->get( "textalign" )."\">";
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
if ($this->params->get( "card_center") == "1") echo "</center>\n";
?>
