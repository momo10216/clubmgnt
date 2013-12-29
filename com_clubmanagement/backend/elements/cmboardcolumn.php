<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Membership
* @copyright	Copyright (c) 2012 Norbert Kümin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

defined('JPATH_BASE') or die;

JFormHelper::loadFieldClass('list');
require_once( dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'nokCMBoard.php');

/**
 * Form Field class for the Joomla Framework.
 *
 * @package	Joomla.Administrator
 * @subpackage	com_clubmanagemnent
 * @since	1.6
 */
class JFormFieldCMBoardColumn extends JFormFieldList {
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'CMBoardColumn';

	/**
	 * Method to get the field options.
	 *
	 * @return	array	The field option objects.
	 * @since	1.6
	 */
	protected function getOptions() {
		// Initialize variables.
		$options = array();

		$cmobject = new nokCMBoard("com_clubmanagement");
		if ($type = $this->element['columntype']) {
			$options = $cmobject->getColumns($type);
		} else {
			$options = $cmobject->getColumns("view");
		}

		// Merge any additional options in the XML definition.
		$options = array_merge(array("" => "<".JText::_('JNONE').">"), $options);
		$options = array_merge(parent::getOptions(), $options);

		return $options;
	}
}
