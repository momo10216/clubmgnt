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
//defined('JPATH_BASE') or die;

use Joomla\CMS\Version;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

/**
 * Supports a modal person picker.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_clubmanagement
 * @since       3.0
 */
class JFormFieldModal_Persons extends JFormField {
	protected $type = 'Modal_Persons';

	protected function getInput() {
		// Load the modal behavior script.
		if (Version::MAJOR_VERSION == '3') {
			JHTML::_('behavior.modal');
		}
		if (Version::MAJOR_VERSION == '4') {
			// Create the modal id.
			$modalId = 'Persons_' . $this->id;
		}

		// attributes
		$allowHousehold = ((string) $this->element['household'] != 'false');
		$allowExcludeCurrentId = ((string) $this->element['excludeCurrentId'] != 'false');
		$allowClear = ((string) $this->element['clear'] != 'false');
		$allowSelect = ((string) $this->element['select'] != 'false');
		$script = array();
		$html	= array();

		// calculate link for select
		$link	= 'index.php?option=com_clubmanagement&amp;view=persons&amp;layout=modal&amp;tmpl=component&amp;function=jSelectPerson_'.$this->id;
		if ($allowHousehold) {
			$link .= "&amp;hh=true";
		}
		if ($allowExcludeCurrentId) {
			$app = JFactory::getApplication();
			if ($id = $app->input->get('id')) {
				$link .= "&amp;excludeid=".$id;
			}
		}
		if ((int) $this->value > 0) {
			$db	= JFactory::getDbo();
			$query = $db->getQuery(true)
				->select("CONCAT(IFNULL(name,''),' ',IFNULL(firstname,''),',',',',IFNULL(address,''),',',IFNULL(city,''))")
				->from($db->quoteName('#__nokCM_persons'))
				->where($db->quoteName('id') . ' = ' . (int) $this->value);
			$db->setQuery($query);
			try {
				$fullname = $db->loadResult();
			} catch (RuntimeException $e) {
				JError::raiseWarning(500, $e->getMessage());
			}
		}

		if (empty($fullname)) {
            $fullname = self::translate('COM_CLUBMANAGEMENT_SELECT_A_PERSON');
		}
		$title = htmlspecialchars($fullname, ENT_QUOTES, 'UTF-8');
		// The active person id field.
		if (0 == (int) $this->value) { $value = ''; } else { $value = (int) $this->value;}

		// Select preparation
		if ($allowSelect) {
			if (Version::MAJOR_VERSION == '3') {
				$script[] = '	function jSelectPerson_'.$this->id.'(id, name, firstname, address, city) {';
				$script[] = '		document.getElementById("'.$this->id.'_id").value = id;';
				$script[] = '		document.getElementById("'.$this->id.'_name").value = name+", "+firstname+", "+address+", "+city;';
				$script[] = '		SqueezeBox.close();';
				$script[] = '	}';
			}
			if (Version::MAJOR_VERSION == '4') {
				$html[] = HTMLHelper::_(
					'bootstrap.renderModal',
					'ModalSelect' . $modalId,
					array(
						'title'       => Text::_('COM_CLUBMANAGEMENT_CHANGE_PERSON'),
						'url'         => $link.'&amp;'.JSession::getFormToken().'=1',
						'height'      => '400px',
						'width'       => '800px',
						'bodyHeight'  => 70,
						'modalWidth'  => 80,
						'footer'      => '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">'
											. Text::_('JLIB_HTML_BEHAVIOR_CLOSE') . '</button>',
					)
				);
				$script[] = '	window.jSelectPerson_' . $this->id . ' = function(id, name, firstname, address, city) {';
				$script[] = '		document.getElementById("' . $this->id . '_id").value = id;';
				$script[] = '		document.getElementById("' . $this->id . '_name").value = name+", "+firstname+", "+address+", "+city;';
			    $script[] = '       $(\'#ModalSelect' . $modalId . '\').modal(\'hide\');';
				$script[] = '	}';
			}

		}

		// clear preparation
		if ($allowClear) {
			$script[] = '	function jClearPerson_'.$this->id.'() {';
			$script[] = '		document.getElementById("'.$this->id.'_id").value = "";';
			$script[] = '		document.getElementById("'.$this->id.'_name").value = "";';
			$script[] = '	}';
		}

		// display input & buttons
		if (Version::MAJOR_VERSION == '3') {
			$html[] = '<span class="input-append">';
			$html[] = '<input type="text" class="input-medium" id="'.$this->id.'_name" value="'.$fullname.'" disabled="disabled" size="35" />';
			if ($allowSelect) {
				$html[] = '<a class="modal btn hasTooltip" title="'.JHtml::tooltipText('COM_CLUBMANAGEMENT_CHANGE_PERSON').'"  href="'.$link.'&amp;'.JSession::getFormToken().'=1" rel="{handler: \'iframe\', size: {x: 800, y: 450}}"><i class="icon-file"></i> '.self::translate('JSELECT').'</a>';
			}
			if ($allowClear) {
				$html[] = '<button type="button" class="btn" id="' . $this->id . '_clear" onclick="window.jClearPerson_' . $this->id . '(\'' . $this->id . '\'); return false;"><span class="icon-remove" aria-hidden="true"></span>' . self::translate('JCLEAR').'</button>';
			}
			$html[] = '</span>';
		} elseif (Version::MAJOR_VERSION == '4') {
			if ($allowSelect || $allowClear) {
				$html[] = '<span class="input-group">';
			}
			$html[] = '<input class="form-control" id="' . $this->id . '_name" type="text" value="' . $title . '" readonly size="35">';
			if ($allowSelect) {
				$html[] = '<button'
					. ' class="btn btn-primary"'
					. ' id="' . $this->id . '_select"'
					. ' data-bs-toggle="modal"'
					. ' data-bs-dismiss="modal"'
					. ' type="button"'
					. ' data-bs-target="#ModalSelect' . $modalId . '">'
					. '<span class="icon-file" aria-hidden="true"></span> ' . Text::_('JSELECT')
					. '</button>';
			}
			if ($allowClear) {
				$html[] = '<button'
					. ' class="btn btn-secondary' . ($value ? '' : ' hidden') . '"'
					. ' id="' . $this->id . '_clear"'
					. ' type="button"'
					. ' onclick="jClearPerson_'.$this->id.'(); return false;">'
					. '<span class="icon-times" aria-hidden="true"></span> ' . Text::_('JCLEAR')
					. '</button>';
			}
			if ($allowSelect || $allowClear) {
				$html[] = '</span>';
			}
		}

		// class='required' for client side validation
		$class = '';
		if ($this->required) {
			$class = ' class="required modal-value"';
		}
		$html[] = '<input type="hidden" id="'.$this->id.'_id"'.$class.' name="'.$this->name.'" value="'.$value.'" />';

		// Add the script to the document head.
		JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));

		return implode("\n", $html);
	}

	protected static function translate($key) {
        if (Version::MAJOR_VERSION == '3') {
            return JText::_($key);
        } elseif (Version::MAJOR_VERSION == '4') {
            return Text::_($key);
        }
        return $key;
	}
}
?>
