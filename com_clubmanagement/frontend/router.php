<?php
/**
* @version		2.5.0
* @package		Joomla
* @subpackage	ClubManagement-Main
* @copyright	Copyright (c) 2012 Norbert Kümin. All rights reserved.
* @license		http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author		Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

function clubmanagementBuildRoute(&$query)
{	
	$segments = array();

	if(isset($query['view'])) 
	{
		$segments[] = $query['view'];
		unset($query['view']);
	};

	return $segments;
}

function clubmanagementParseRoute($segments)
{
	$vars = array();

	//Get the active menu item
	$menu =& JSite::getMenu();
	$item =& $menu->getActive();
	
	if (is_object($item)) {
		if (isset($item->query['view']) && $item->query['view'] == 'member' && isset($segments[0])) {
			$vars['view']	= 'member';
		}
	} else {
		// Count route segments
		$count = count($segments);

		// Check if there are any route segments to handle.
		if ($count) {
			if (count($segments[0]) == 1) {
				$vars['view']	= 'member';
			} else {
				$vars['view']	= 'member';
			}
		}
	}
	return $vars;
}
