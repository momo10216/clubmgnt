<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Member
* @copyright	Copyright (c) 2012 Norbert KUEmin. All rights reserved.
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

$FieldPerLine=4;
$Line=5;
$details = false;
$EOL = "\n";

function getImageDir($imageDir) {
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
	return $imageDir;
}

if ($this->paramsMenuEntry->get('detail_enable') != '0') {
	$details = true;
	if (Version::MAJOR_VERSION == '3') {
		$curi = JFactory::getURI();
		$uri = JURI::getInstance( $curi->toString() );
	} else {
		$uri = Uri::getInstance();
	}
	$uri->setVar('layout','detail');
	$uri->setVar('tmpl','component');
	$uri->setVar('Itemid','');
	$uri->setVar('view','person');
	$uri->setVar('option','com_clubmanagement');
	$uri->setVar('iframe','1');
	$detailWidth = $this->paramsComponent->get('detail_width');
	$detailHeight = $this->paramsComponent->get('detail_height');
}
// Get columns
$cols = array();
for ($i=1;$i<=20;$i++) {
	$field = 'column_'.$i;
	$cols[] = $this->paramsMenuEntry->get($field );
}
$colcount = count($cols);
// Display
$cssText = '';
switch ($this->paramsMenuEntry->get('border_type')) {
	case 'row':
		$cssText .= '.cmTableBorder { border-top-style:solid; border-width:1px; }'.$EOL;
		break;
	case 'grid':
		$cssText .= '.cmTableBorder { border-style:solid; border-width:1px; }'.$EOL;
		break;
	default:
		$cssText .= '.cmTableBorder {  }'.$EOL;
		break;
}
$cssText .= '.cmTableCellTextAlign { text-align: '.$this->paramsMenuEntry->get('textalign').'; }'.$EOL;
$imgSize = intval($this->paramsMenuEntry->get('image_size_value'));
if ($imgSize > 0) {
	if (($this->paramsMenuEntry->get('image_size_uom') == '%') && ($imgSize >100)) { $imgSize = 100; }
	$cssText .= '.cmTableImage { width: '.$imgSize.$this->paramsMenuEntry->get('image_size_uom').'; height: auto; }'.$EOL;
} else {
	$cssText .= '.cmTableImage { }'.$EOL;
}
$doc = JFactory::getDocument();
$doc->addStyleDeclaration($cssText);
$imageDir = getImageDir($this->paramsComponent->get('image_dir'));
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
if ($this->paramsMenuEntry->get('table_center') == '1') echo '<center>'.$EOL;
if ($this->items) {
	JLoader::register('SelectionHelper', JPATH_COMPONENT_ADMINISTRATOR.'/helpers/selection.php', true);
	$memberTypes = SelectionHelper::getSelection('member_types');
	foreach($this->items as $item) {
		$row = (array) $item;
		$lines = array();
		$imageCol = $this->paramsMenuEntry->get('column_image');
		if ($imageCol != '') {
			$image = $row[$imageCol];
		}
		if ($details) {
			$id = $item->person_id;
			$uri->setVar('id',$id);
		}
		for($i=0;$i<$Line;$i++) {
			$lines[$i] = '';
			for($j=0;$j<$FieldPerLine;$j++) {
				$colnr = $i*$FieldPerLine+$j;
				$field = $cols[$colnr];
				$data = '';
				if (($field == 'member_type') && !empty($memberTypes[$row[$field]])) {
					$data = $memberTypes[$row[$field]];
				} else {
					if (isset($row[$field])) { $data = $row[$field]; }
				}
				if (strlen($data) > 0) {
					if ($lines[$i]) { $lines[$i] .= " "; }
					if ($details && ($this->paramsMenuEntry->get('detail_column_link') == $field) && ($data != "")) {
						if (Version::MAJOR_VERSION == '3') {
							$data = '<a href="'.$uri->toString().'" class="modal" rel="{handler: \'iframe\', size: {x: '.$detailWidth.', y: '.$detailHeight.'}}">'.$data.'</a>';
						} elseif (Version::MAJOR_VERSION == '4') {
							$title = $item->person_firstname.' '.$item->person_name;
							$data = "<a href=\"#\" data-bs-toggle=\"modal\" data-bs-target=\"#modal-box\" onClick=\"return clickModal('".$uri->toString()."','".$title."');\">".$data."</a>";
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
					}
					$lines[$i] .= $data;
					$lines[$i] = trim($lines[$i]);
				}
			}
			if ($details && ($this->paramsMenuEntry->get('detail_column_link') == '') && ($data != '')) {
				$lines[$i] = '<a href="'.$uri->toString().'" class="modal" rel="{handler: \'iframe\', size: {x: '.$detailWidth.', y: '.$detailHeight.'}}">'.$lines[$i].'</a>';
			}
		}
		echo '<table class="cmTableBorder">'.$EOL;
		switch ($this->paramsMenuEntry->get('picpos')) {
			case 'right': //picture on the right side
				echo '<tr valign="top">'.$EOL;
				echo '<td class="cmTableCellTextAlign">';
				for($i=0;$i<$Line;$i++) {
					if (strlen($lines[$i]) > 0) {
						echo $lines[$i].'<br />';
					}
				}
				echo '</td>'.$EOL;
				if ($image) {
					echo '<td class="cmTableCellTextAlign"><img src="'.$imageDir.$image.'" class="cmTableImage"></td>'.$EOL;
				}
				echo '</tr>'.$EOL;
				break;
			case 'top': //picture on the top
				echo '<tr valign="top">'.$EOL;
				if ($image) {
					echo '<td class="cmTableCellTextAlign"><img src="'.$imageDir.$image.'" class="cmTableImage"></td>'.$EOL;
				}
				echo '</tr>'.$EOL;
				echo '<tr valign="top">'.$EOL;
				echo '<td class="cmTableCellTextAlign">';
				for($i=0;$i<$Line;$i++) {
					if (strlen($lines[$i]) > 0) {
						echo $lines[$i].'<br />';
					}
				}
				echo '</td>'.$EOL;
				echo '</tr>'.$EOL;
				break;
			case 'bottom': //picture on the bottom
				echo '<tr valign="top">'.$EOL;
				echo '<td class="cmTableCellTextAlign">';
				for($i=0;$i<$Line;$i++) {
					if (strlen($lines[$i]) > 0) {
						echo $lines[$i].'<br />';
					}
				}
				echo '</td>'.$EOL;
				echo '</tr>'.$EOL;
				echo '<tr valign="top">'.$EOL;
				if ($image) {
					echo '<td class="cmTableCellTextAlign"><img src="'.$imageDir.$image.'" class="cmTableImage"></td>'.$EOL;
				}
				echo '</tr>'.$EOL;
				break;
			case 'left': //picture on the left side
			default:
				echo '<tr valign="top">';
				if ($image) {
					echo '<td class="cmTableCellTextAlign"><img src="'.$imageDir.$image.'" class="cmTableImage"></td>'.$EOL;
				}
				echo '<td class="cmTableCellTextAlign">';
				for($i=0;$i<$Line;$i++) {
					if (strlen($lines[$i]) > 0) {
						echo $lines[$i].'<br />';
					}
				}
				echo '</td>'.$EOL;
				echo '</tr>'.$EOL;
				break;
		}
		echo '</table>'.$EOL;
		echo '<p/>'.$EOL;
	}
}
if ($this->paramsMenuEntry->get( "table_center") == "1") echo "</center>\n";
?>
