<?php
/**
* @version	2.5.0
* @package	Joomla
* @subpackage	ClubManagement-Main
* @copyright	Copyright (c) 2012 Norbert Kümin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.controller');

/**
 * Content Component Controller
 *
 * @package		Joomla
 * @subpackage	Content
 * @since 1.5
 */
class clubmanagementController extends JController
{
	/**
	 * Method to show an article as the main page display
	 *
	 * @access	public
	 * @since	1.5
	 */
	function display()
	{
		// View caching logic -- simple... are we logged in?
		$user = &JFactory::getUser();
		parent::display();
	}
}
