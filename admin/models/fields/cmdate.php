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
 
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('calendar');

// The class name must always be the same as the filename (in camel case)
class JFormFieldCmDate extends JFormFieldCalendar {
        //The field class must know its own type through the variable $type.
        protected $type = 'cmdate';
 	protected $defaultFormatDate = 'Y-m-d';
 	protected $defaultFormatTimestamp = 'Y-m-d H:i:s';
	protected $interval = 'P1D';

        public function getInput() {

		// Build the attributes array.
		$attributes = array();

		empty($this->size)      ? null : $attributes['size'] = $this->size;
		empty($this->maxlength) ? null : $attributes['maxlength'] = $this->maxlength;
		empty($this->class)     ? null : $attributes['class'] = $this->class;
		!$this->readonly        ? null : $attributes['readonly'] = '';
		!$this->disabled        ? null : $attributes['disabled'] = '';
		empty($this->onchange)  ? null : $attributes['onchange'] = $this->onchange;
		empty($hint)            ? null : $attributes['placeholder'] = $hint;
		$this->autocomplete     ? null : $attributes['autocomplete'] = 'off';
		!$this->autofocus       ? null : $attributes['autofocus'] = '';
		!$this->autofocus       ? null : $attributes['autofocus'] = '';

		if ($this->required) {
			$attributes['required'] = '';
			$attributes['aria-required'] = 'true';
		}

		if (!$this->value || $this->value == JFactory::getDbo()->getNullDate() || strtotime($this->value) === false || $this->value == '0000-00-00') {
			$this->value = '';
		}
		$date = new DateTime("now");

		if ($this->element['showtime'] == 'true') {
			$format = $this->element['format'] ? (string) $this->element['format'] : $this->defaultFormatTimestamp;
		} else {
			$format = $this->element['format'] ? (string) $this->element['format'] : $this->defaultFormatDate;
		}
		$validFormat = preg_replace('/%/', '', $format);

		if ($this->element['default'] == 'start') {
			$this->value = $date->format($validFormat);
		} else if ($this->element['default'] == 'end') {
			$date->add(new DateInterval($this->interval));
			$this->value = $date->format($validFormat);
		}

		return JHtml::_('calendar', $this->value, $this->name, $this->id, $format, $attributes);
        }
}
?>
