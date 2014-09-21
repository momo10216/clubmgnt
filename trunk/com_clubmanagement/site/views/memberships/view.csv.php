<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Member
* @copyright	Copyright (c) 2012 Norbert Kümin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die;

class ClubManagementViewMemberships extends JViewLegacy {
	protected $items;
	protected $pageHeading = 'COM_CLUBMANAGEMENT_PAGE_TITLE_DEFAULT';
	protected $paramsComponent;
	protected $paramsMenuEntry;
	protected $user;
	protected $header = array();
	protected $data = array();
	protected $filename = "export.csv";
	protected $encoding;
	protected $delimiter;


	function display($tpl = null)   {
		/*
		 * Init variables
		 */
		$this->user =& JFactory::getUser();
		$app = JFactory::getApplication();
		$this->items = $this->get('Items');
		$this->state = $this->get('State');
		$this->paramsComponent = $this->state->get('params');
		$currentMenu = $app->getMenu()->getActive();
		if (is_object( $currentMenu )) {
			$this->paramsMenuEntry = $currentMenu->params;
		}
		$csvData = array();
		$this->encoding = $this->paramsMenuEntry->get('csv_encoding', 'utf-8');
		$this->delimiter = $this->paramsMenuEntry->get('csv_delimiter', ';');

		require_once( dirname(__FILE__).DIRECTORY_SEPARATOR.'tmpl.csv'.DIRECTORY_SEPARATOR.$this->getLayout().'.php');

		/*
		 * prepare header
		 */
		if ($this->paramsMenuEntry->get('show_header', '1') == '1') {
			array_push($csvData, $this->header);
		}

		/*
		 * Call Layout (CSV)
		 */
		foreach($this->data as $row) {
			array_push($csvData, $row);
		}
		/*
		 * Output
		 */
		JLoader::register('CvsHelper', JPATH_COMPONENT_ADMINISTRATOR.'/helpers/cvs.php', true);
		CvsHelper::saveCVS($csvData, $this->encoding, $this->filename, $this->delimiter);
	}
}
?>
