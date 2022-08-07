<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Member
* @copyright	Copyright (c) 2014 Norbert Kuemin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Version;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Factory;

$details = false;
if ($this->paramsMenuEntry->get('detail_enable') != "0") {
	$details = true;
	if (Version::MAJOR_VERSION == '3') {
		$curi = JFactory::getURI();
		$uri = JURI::getInstance( $curi->toString() );
	} else {
		$uri = Uri::getInstance();
	}
	$uri->setVar("layout","detail");
	$uri->setVar("tmpl","component");
	$uri->setVar("Itemid","");
	$uri->setVar("view","person");
	$uri->setVar('option','com_clubmanagement');
	$uri->setVar('iframe','1');
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
	if (Version::MAJOR_VERSION == '3') {
		JHTML::_('behavior.modal');
	}
	if (Version::MAJOR_VERSION == '4') {
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
	} 
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
					if (Version::MAJOR_VERSION == '3') {
						echo "<a href=\"".$uri->toString()."\" class=\"modal\" rel=\"{handler: 'iframe', size: {x: ".$detailWidth.", y: ".$detailHeight."}}\">".$data."</a>";
					} elseif (Version::MAJOR_VERSION == '4') {
						$title = $item->person_firstname.' '.$item->person_name;
						echo "<a href=\"#\" data-bs-toggle=\"modal\" data-bs-target=\"#modal-box\" onClick=\"return clickModal('".$uri->toString()."','".$title."');\">".$data."</a>";
					}
				} else {
					switch ($field) {
						case 'person_url':
							$data = '<a href="'.$data.'" target="_new">'.$data.'</a>';
							break;
						case 'person_email':
							$data = '<a href="mailto:'.$data.'">'.$data.'</a>';
							break;
					}
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
