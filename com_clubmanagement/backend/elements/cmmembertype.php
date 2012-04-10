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
require_once( dirname(__FILE__).DS.'..'.DS.'classes'.DS.'nokCMMembership.php');

class JFormFieldCMMemberType extends JFormFieldList {
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'CMMemberType';

	/**
	 * Method to get the field options.
	 *
	 * @return	array	The field option objects.
	 * @since	1.6
	 */
	protected function getOptions() {
		// Initialize variables.
		$options = array();

		$cmobject = new nokCMMembership("com_clubmanagement");
		$options = $cmobject->getMemberTypes();

		// Merge any additional options in the XML definition.
		$options = array_merge(parent::getOptions(), $options);

		return $options;
	}
}

