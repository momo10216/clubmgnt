<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Tools
* @copyright	Copyright (c) 2014 Norbert Kuemin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

/**
 * CVS helper.
 *
 * @package     Joomla
 * @subpackage  com_clubmanagement
 * @since       3.0
 */
class PdfLabelsHelper {
	public static function saveLabels($data, $settings = array(), $filename = 'output.pdf') {
		$pdf = self::_initPdf();
		self::_printLabels($pdf, $data, $settings);
		$buffer = self::_finishPdf($pdf);
		header('Content-Type: application/pdf');
		header('Content-Length: '.strlen($buffer));
		header('Content-Disposition: attachment; filename="'.$filename.'"');
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Pragma: no-cache');
		print $buffer;
		// Close the application.
		$app = JFactory::getApplication();
		$app->close();
	}

	private static function _initPdf($settings) {
		$pdf = PDF_new();
		$optlist = 'destination={page=1 type=fixed top=100 left=50}';
		if (PDF_begin_document($pdf, "", "") == 0) {
			die("Error: " . PDF_get_errmsg($pdf));
		}
		$user = JFactory::getUser();
		PDF_set_info($pdf, "Creator", "PdfLabelsHelper");
		if (!$user->guest) {
			PDF_set_info($pdf, "Author", $user->name);
		}
		PDF_set_info($pdf, "Title", "Labels");
		return $pdf;
	}

	private static function _initPdf() {
		PDF_end_document($pdf, "");
		return PDF_get_buffer($pdf);
	}

	private _calcMilimeterToPoints($amount) {
		return intval($amount*2.833333333+0.5);
	}

	private _printLabels($pdf, $data, $settings) {
		$row = 1;
		$col = 1;
	}
}
?>
