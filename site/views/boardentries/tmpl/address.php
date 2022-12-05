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

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Factory;

$FieldPerLine=4;
$Line=5;
$details = false;
if ($this->paramsMenuEntry->get( 'detail_enable' ) != "0") {
	$details = true;
	$detailWidth = $this->paramsComponent->get('detail_width');
	$detailHeight = $this->paramsComponent->get('detail_height');
    $uri = Uri::getInstance();
    $document = Factory::getApplication()->getDocument();
    $document->addScriptDeclaration("function clickModal(url, title) {
    modalbox = document.getElementById('modal-box');
    if (modalbox) {
        var modalTitle = modalbox.querySelector('.modal-title');
        modalTitle.textContent = title;
        var modalBody = modalbox.querySelector('.modal-body');
        fetch(url).then((response) =>
            response.text().then((content) => {
                modalBody.innerHTML = content;
            })
        )
    }
    return false;
}
");
    echo HTMLHelper::_(
        'bootstrap.renderModal',
        'modal-box',
        array(
            'modal-dialog-scrollable' => true,
            'url'    => '',
            'title'  => '',
            'height' => '100%',
            'width'  => '100%',
            'modalWidth'  => $detailHeight,
            'bodyHeight'  => $detailWidth,
            'footer' => '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-hidden="true">'
                . \Joomla\CMS\Language\Text::_('JLIB_HTML_BEHAVIOR_CLOSE') . '</button>'
        ),
        '<div id="modal-body">Content set by ajax.</div>'
    );
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
	$header = $this->getModel()->getHeader($cols, true);
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
                            $title = $item->person_firstname.' '.$item->person_name;
                            $data = "<a href=\"#\" data-bs-toggle=\"modal\" data-bs-target=\"#modal-box\" onClick=\"return clickModal('".$uri->toString()."','".$title."');\">".$data."</a>";
						} else {
							if ($field == 'person_url') {
								$data = '<a href="'.$data.'" target="_new">'.$data.'</a>';
							}
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
