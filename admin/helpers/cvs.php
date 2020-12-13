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
class CvsHelper {
	public static function saveCVS($data, $encoding, $filename, $delimiter = ';') {
		$content = self::array2cvs($data, $delimiter);
		if ($encoding != "utf-8") {
			$content = iconv("UTF-8", strtoupper($encoding)."//TRANSLIT", $content); 
		}
		header('Content-Type: application/cvs; charset='.$encoding);
		header('Content-Length: '.strlen($content));
		header('Content-Disposition: attachment; filename="'.$filename.'"');
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Pragma: no-cache');
		print $content;
		// Close the application.
		$app = JFactory::getApplication();
		$app->close();
	}

	public static function loadCVS($content, $encoding, $delimiter = ';') {
		$content = mb_convert_encoding($content, $encoding, 'Windows-1252');
		//$content = iconv($encoding, "UTF-8"."//TRANSLIT", $content); 
		if (substr($content,0,3) == "\357\273\277") { $content = substr($content,3); } //Remove known BOM
		return self::cvs2array($content, $delimiter);
	}

	public static function array2cvs ($data, $delimiter) {
		$content = "";
		foreach ($data as $row) {
			$count = count($row);
			if ($count > 0) {
				for ($i=0; $i < $count; $i++) {
					$row[$i] = self::cvs_encode_field($row[$i],$delimiter);
				}
			}
			$content .= self::cvs_encode_line(implode($delimiter,$row))."\n";
		}
		return $content;
	}

	public static function cvs2array($content, $delimiter) {
		$data = array();
		$content = str_replace("\r","\n",$content);
		$content = str_replace("\n\n","\n",$content);
		$rows = explode("\n",trim($content));
		foreach ($rows as $row) {
			if (trim($row)) {
				$row = self::cvs_decode_line($row);
				$fields = explode($delimiter,$row);
				$result_fields = array();
				foreach ($fields as $field) {
					array_push($result_fields, self::cvs_decode_field($field,$delimiter));
				}
				array_push($data, $result_fields);
			}
		}
		return $data;
	}

	public static function cvs_encode_field($text,$delimiter) {
		$text = str_replace('%','%25',$text);
		$text = str_replace($delimiter,'%'.dechex(ord($delimiter)),$text);
		return $text;
	}

	public static function cvs_encode_line($text) {
		$text = str_replace("\n","%0A",$text);
		$text = str_replace("\r","%0D",$text);
		return $text;
	}

	public static function cvs_decode_field($text,$delimiter) {
		$text = str_replace("%".dechex(ord($delimiter)),$delimiter,$text);
		$text = str_replace("%25","%",$text);
		return $text;
	}

	public static function cvs_decode_line($text) {
		$text = str_replace("%0A","\n",$text);
		$text = str_replace("%0D","\r",$text);
		return $text;
	}
}
?>
