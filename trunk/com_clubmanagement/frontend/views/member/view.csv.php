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

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die;

jimport( 'joomla.application.component.view' );
require_once( JPATH_COMPONENT_ADMINISTRATOR.DS.'classes'.DS.'nokCMMembership.php');

class ClubmanagementViewmember extends JView {
	var $user;
	var $document;
	var $params;
	var $params_menu;
	var $header;
	var $data;
	var $menu;
	var $csv_delimiter;

	function _Array2CSV($arrInput) {
		$strCSV = '';
		foreach($arrInput as $strSingle) {
			$strCSV .= $this->csv_delimiter.'"'.addslashes($strSingle).'"';
		}
		$strCSV= substr($strCSV,1);
		return $strCSV;
	}

	function display($tpl = null)   {
		/*
		 * Init variables
		 */
		$this->user =& JFactory::getUser();
		$this->params = &JComponentHelper::getParams( 'com_clubmanagement' );
		$menus = &JSite::getMenu();
		$this->menu = $menus->getActive();
		$cmobject = new nokCMMembership("com_clubmanagement");
		if (is_object( $this->menu )) {
			$this->params_menu = $this->menu->params;
			$this->csv_delimiter = $this->params_menu->get( 'csv_delimiter' );
		}

		/*
		 * Call Layout (CSV)
		 */
		require_once( dirname(__FILE__).DS.'tmpl.csv'.DS.$this->getLayout().'.php');

		/*
		 * Output result
		 */
		$content = "";
		if ($this->params_menu->get( 'show_header' ) != "0") {
			$content .= $this->_Array2CSV($this->header)."\n";
		}
		if ($this->data) {
			foreach($this->data as $row) {
				$content .= $this->_Array2CSV($row)."\n";
			}
		}
		if ($this->params_menu->get( 'csv_encoding' ) != "UTF-8") {
			$content = iconv( "UTF-8", $this->params_menu->get( 'csv_encoding' )."//TRANSLIT", $content ); 
		}
		header('Content-Type: application/csv; charset='.strtolower($this->params_menu->get('csv_encoding')));
		header("Content-Length:".strlen($content));
		header('Content-Disposition: attachment; filename="' . $this->filename . '"');
		header("Content-Transfer-Encoding: binary");
		header('Expires: 0');
		header('Pragma: no-cache');
		print $content;

		// Close the application.
		$app = &JFactory::getApplication();
		$app->close(); 
	}
}
?>
