<?php
/**
* @version		0.5
* @package		Joomla
* @subpackage	ClubManagement-Membership
* @copyright	Copyright (c) 2009 Norbert Kümin. All rights reserved.
* @license		http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author		Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );
require_once( JPATH_COMPONENT_ADMINISTRATOR.DS.'classes'.DS.'nokCMMembership.php');

class cmViewmember extends JView
{
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

		global $mainframe;
		
		/*
		 * Init variables
		 */
		$this->user		=& JFactory::getUser();
		$this->params	=& $mainframe->getParams();
		$menus	= &JSite::getMenu();
		$this->menu	= $menus->getActive();
		$cmobject = new nokCMMembership("com_clubmanagement");
		if (is_object( $this->menu )) {
			$this->params_menu = new JParameter( $this->menu->params );
			$this->csv_delimiter = $this->params_menu->get( 'csv_delimiter' );
		}

		/*
		 * Get columns
		 */
		$cols = array();
		for ($i=1;$i<=20;$i++)
		{
			$field = "column_".$i;
			$cols[] = $this->params_menu->get( $field );
		}

		/*
		 * Calculate where
		 */
		$where = "";
		if ($this->params_menu->get( 'memberstate' ) == "current")
		{
			$where = "`end` IS NULL";
		}
		if ($this->params_menu->get( 'memberstate' ) == "closed")
		{
			$where = "`end` IS NOT NULL";
		}
		if ($this->params_menu->get( 'membertype' ) != "*")
		{
			if ($where != "") { $where = $where . " AND "; } 
			$where = $where . "`type`='".$this->params_menu->get( 'membertype' )."'";
		}

		/*
		 * Get data
		 */
		$this->data = $cmobject->getViewData($cols,$where,"`name`,`firstname`");

		//JToolBarHelper::back();
		$exportFilename = date('Y-m-d') . '_export' . '.csv';

/*
		JResponse::clearHeaders();
		JResponse::setHeader('Pragma', 'public', true);
		JResponse::setHeader('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT', true);            // Date in the past
		JResponse::setHeader('Last-Modified', gmdate('D, d M Y H:i:s') . ' GMT', true);
		JResponse::setHeader('Cache-Control', 'no-store, no-cache, must-revalidate', true);   // HTTP/1.1
		JResponse::setHeader('Cache-Control: pre-check=0, post-check=0, max-age=0', true);   // HTTP/1.1
		JResponse::setHeader('Pragma', 'no-cache', true);
		JResponse::setHeader('Expires', '0', true);
		JResponse::setHeader('Content-Transfer-Encoding', 'none', true);
		JResponse::setHeader('Content-Type', 'application/csv', true); // joomla will overwrite this...
		JResponse::setHeader('Content-Disposition', 'attachment; filename="'. $exportFilename . '"', true);
		// joomla overwrites content-type, we can't use JResponse::setHeader()
		$this->document	=& JFactory::getDocument();
		//$type = "application/csv";
		$type = "application/save";
		$this->document->setMimeEncoding($type);
		$this->document->setType($type);
		//$this->document->setModifiedDate(gmdate('D, d M Y H:i:s') . ' GMT');
		ob_end_flush();
		JResponse::sendHeaders();
*/
		$content = "";
		if ($this->params_menu->get( 'show_header' ) != "0") {
			$this->header = $cmobject->getViewHeader($cols);
			$content .= $this->_Array2CSV($this->header)."\n";
		}
		foreach($this->data as $row) {
			$content .= $this->_Array2CSV($row)."\n";
		}
		header('Content-Type: application/csv; charset=utf-8');
		header("Content-Length:".strlen($content));
		header('Content-Disposition: attachment; filename="' . $exportFilename . '"');
		header("Content-Transfer-Encoding: binary");
		header('Expires: 0');
		header('Pragma: no-cache');
		if ($this->params_menu->get( 'csv_encoding' ) != "UTF-8") {
			$content = iconv( "UTF-8", $this->params_menu->get( 'csv_encoding' )."//TRANSLIT", $content ); 
		}
		print $content;
		// Close the application.
		$app = &JFactory::getApplication();
		$app->close(); 
	}
}
?>
