<?php
/**
* @version		0.5
* @package		Joomla
* @subpackage	ClubManagement-Main
* @copyright	Copyright (c) 2009 Norbert Kümin. All rights reserved.
* @license		http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author		Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once( JApplicationHelper::getPath( 'toolbar_html' ) );

switch ($task)
{
	case 'add' :
		TOOLBAR_clubmanagement::_EDIT(false);
		break;
	case 'edit':
		TOOLBAR_clubmanagement::_EDIT(true);
		break;
	default:
		TOOLBAR_clubmanagement::_DEFAULT();
		break;
}