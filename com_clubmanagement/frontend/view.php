<?php
/**
* @version		0.5
* @package		Joomla
* @subpackage	ClubManagement-Main
* @copyright	Copyright (c) 2009 Norbert K�min. All rights reserved.
* @license		http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author		Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.view');

class CMView extends JView
{
	function __construct($config = array())
	{
		parent::__construct($config);

		//Add the helper path to the JHTML library
		JHTML::addIncludePath(JPATH_COMPONENT.DS.'helpers');
	}
}