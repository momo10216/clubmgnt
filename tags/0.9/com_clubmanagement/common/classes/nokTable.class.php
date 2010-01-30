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

class nokTable
{
	var $db;
	var $table = "";
	var $toolbar_entry = array();
	var $column_req = array();
	var $column_rep = array();
	var $column_list = array();
	var $column_edit = array();
	var $column_show = array();
	var $column_external = array();
	var $column_view = array();
	var $default_order = array();
	var $settings = array();
	var $gid;
	var $objectname;
	var $column_delimiter;
	var $delete_rule = array();
	var $filter = array();

	function nokTable ($strTable, $objectname)
	{
		$this->column_delimiter = ":";
		$this->db =& JFactory::getDBO();
		$user =& JFactory::getUser();
		$this->gid = $user->get('aid', 0);
		$this->setTable($strTable);
		$this->setObjectName($objectname);
	}

	function setTable($strTable)
	{
		$this->table = $strTable;
	}

	function getTable()
	{
		return $this->table;
	}

	function setObjectName($strObject)
	{
		$this->objectname = $strObject;
	}

	function getObjectName()
	{
		return $this->objectname;
	}

	function getSelectionArray($strText)
	{
		$arrResult = array();
		$aDefList = split(";",$strText);
		reset($aDefList);
		foreach ($aDefList as $entry) {
			$aDef = split("=",$entry,2);
			$arrResult[$aDef[0]] = JText::_($aDef[1]);
		}
		return $arrResult;
	}

/*
Known toolbar functions:
publish, unpublish, add, edit, delete, export, import, preferences, help
*/
	function addToolbarEntry($strFunction)
	{
		$this->toolbar_entry[$strFunction] = 1;
	}

	function isToolbarEntrySet($strFunction)
	{
		if ($this->toolbar_entry[$strFunction] == 1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function addColumnMandatory($strColumn)
	{
		$this->column_req[$strColumn] = 1;
	}

	function isColumnMandatory($strColumn)
	{
		if ($this->column_req[$strColumn] == 1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function addSetting($name,$value)
	{
		$this->settings[$name] = $value;
	}

	function getSetting($name)
	{
		return $this->settings[$name];
	}

/*
Type & parameter description:

Type			Param1		Param2		Param3		Param4		Param5		Param6		Param7		Param8		Param9
----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
text			width			maxsize		height
email			width			maxsize
url			width			maxsize
checkbox
publish
datetime
password		width			maxsize		minsize
readonly		Default Insert	Default Update
image		directory
selection		KeyColumn		ValueColumn	Table			Where		Order		Null-Lable
textselect		v1=d1;v2=d2,...	Null-Lable
category		Name

Default Insert / Default Update
CurrentUser
Timestamp
CurrentIP

*/
	function addColumnRepresentation($strColumn, $strType, $strParam1="", $strParam2="", $strParam3="", $strParam4="", $strParam5="", $strParam6="", $strParam7="", $strParam8="", $strParam9="")
	{
		if (strpos($strColumn,$this->column_delimiter) !== false)
		{
			//Name, Column, Table, Link, [Table-Alias]
			$arrTemp = split($this->column_delimiter,$strColumn,5);
			switch (count($arrTemp))
			{
				case 2: //name:column
					$this->column_external[$arrTemp[0]] = array($arrTemp[1], $this->table, "", $this->table);
					break;
				case 4: //name:column:table:join
					$this->column_external[$arrTemp[0]] = array($arrTemp[1], $arrTemp[2], $arrTemp[3], $arrTemp[2]);
					break;
				case 5: //name:column:table:join:tablealias
					$this->column_external[$arrTemp[0]] = array($arrTemp[1], $arrTemp[2], $arrTemp[3], $arrTemp[4]);
					break;
				default:
					nokCM_error(JText::sprintf( 'ERROR_INCORRECT_REPRESENTATION', $strColumn), false);
					return;
					break;
			}
		}
		$this->column_rep[$strColumn] = array($strType, $strParam1, $strParam2, $strParam3, $strParam4, $strParam5, $strParam6, $strParam7, $strParam8, $strParam9);
	}

	function addColumnDisplay($strDisplay, $strColumn, $strTitle)
	{
		switch (strtolower($strDisplay))
		{
			case 'list':
				$this->column_list[$strColumn] = $strTitle;
				break;
			case 'show':
				$this->column_show[$strColumn] = $strTitle;
				break;
			case 'edit':
				$this->column_edit[$strColumn] = $strTitle;
				break;
			case 'export':
				$this->column_export[$strColumn] = $strTitle;
				break;
			case 'view':
				$this->column_view[$strColumn] = $strTitle;
				break;
		}
	}

	function addDeleteRule($type, $localColumn, $extTable, $extColumn)
	{
		$this->delete_rule[] = array($type, $localColumn, $extTable, $extColumn);
	}

	function setDefaultOrder($strDisplay, $strOrder)
	{
		$this->default_order[$strDisplay] = $strOrder;
	}

	function addListFilter($name, $type, $column, $valuelist)
	{
		$this->filter[] = array ($name, $type, $column, $valuelist);
	}

	function _calcquery($columns, $where, $order, $idcol="")
	{
		//Query
		reset($columns);
		$strTableList = "`".$this->table."` T0";
		$strJoinList = "";
		$intTableCount = 1;
		$arrExternalTable = array();
		$arrExternalTable[$this->table] = "T0";
		if ($idcol == "")
		{
			$strColumnList = "";
		}
		else
		{
			$strColumnList = $this->table.".`".$idcol."`";
		}
		while (list($strColumn,$strTitle) = each($columns))
		{
			if ($strColumnList != "") $strColumnList = $strColumnList . ", ";
			if ($this->column_external[$strColumn])
			{
				//Column, Tab le, Link, Tablealias
				$arrTemp = $this->column_external[$strColumn];
				if (!$arrExternalTable[$arrTemp[3]])
				{
					$strTablePrefix = "T".$intTableCount;
					$intTableCount++;
					$arrExternalTable[$arrTemp[3]] = $strTablePrefix;
					if ($strTableList != "") $strTableList = $strTableList . ", ";
					$strTableList = $strTableList."`".$arrTemp[1]."` ".$strTablePrefix;
					if ($strJoinList != "") $strJoinList = $strJoinList . " AND ";
					$strJoinList = $strJoinList.$arrTemp[2];
					$arrExternalTable[$arrTemp[3]] = $strTablePrefix;
				}
				if (strpos($arrTemp[0],"`") === false)
				{
					$strColumn = $arrExternalTable[$arrTemp[3]].".`".$arrTemp[0]."` `".$strColumn."`";
				}
				else
				{
					$strColumn = str_replace($arrTemp[3].".`",$arrExternalTable[$arrTemp[3]].".`",$arrTemp[0])." `".$strColumn."`";
				}
			}
			else
			{
				if (strpos($strColumn,"`") === false)
				{
					$strColumn = "T0.`".$strColumn."` `".$strColumn."`";
				}
				else
				{
					$strColumn = str_replace($this->table.".`","T0.`",$arrTemp[0])." `".$strColumn."`";
				}
			}
			$strColumnList = $strColumnList.$strColumn;
		}
		reset($this->column_rep);
		while (list($strColumn,$arrRep) = each($this->column_rep))
		{
			if ($this->column_external[$strColumn])
			{
				//Column, Tab le, Link, Alias
				$arrTemp = $this->column_external[$strColumn];
				if (!$arrExternalTable[$arrTemp[3]])
				{
					$strTablePrefix = "T".$intTableCount;
					$intTableCount++;
					$arrExternalTable[$arrTemp[3]] = $strTablePrefix;
					if ($strTableList != "") $strTableList = $strTableList . ", ";
					$strTableList = $strTableList."`".$arrTemp[1]."` ".$strTablePrefix;
					if ($strJoinList != "") $strJoinList = $strJoinList . " AND ";
					$strJoinList = $strJoinList.$arrTemp[2];
					$arrExternalTable[$arrTemp[3]] = $strTablePrefix;
				}
				if (strpos($arrTemp[0],"`") === false)
				{
					$where = str_replace("`".$arrTemp[0]."`",$arrTemp[3].".`".$arrTemp[0]."`",$where);
					$order = str_replace("`".$arrTemp[0]."`",$arrTemp[3].".`".$arrTemp[0]."`",$order);
				}
			}
			else
			{
				if (strpos($strColumn,"`") === false)
				{
					$where = str_replace("`".$strColumn."`","T0.`".$strColumn."`",$where);
					$order = str_replace("`".$strColumn."`","T0.`".$strColumn."`",$order);
				}
			}
		}
		$strSQL = "SELECT " . $strColumnList . " FROM ".$strTableList;
		if ($strJoinList != "")
		{
			if ($where != "")
			{
				$where = $strJoinList . " AND " . $where;
			}
			else
			{
				$where = $strJoinList;
			}
		}
		if ($where != "") $strSQL = $strSQL . " WHERE " . $where;
		if ($order != "") $strSQL = $strSQL . " ORDER BY " . $order;
		reset($arrExternalTable);
		while (list($strTable,$strPrefix) = each($arrExternalTable))
		{
			$strSQL = str_replace($strTable.".",$strPrefix.".",$strSQL);
		}
//echo $strSQL;
		return $strSQL;
	}

	function getColumns($strType)
	{
		switch (strtolower($strType))
		{
			case 'list':
				return $this->column_list;
				break;
			case 'show':
				return $this->column_show;
				break;
			case 'edit':
				return $this->column_edit;
				break;
			case 'view':
				return $this->column_view;
				break;
		}
		return array();
	}

	function getViewData($columns, $where, $order)
	{
		//Calculate colum array
		$arrColumns = array();
		while (list($strKey,$strColumn) = each($columns))
		{
			if ($strColumn != "")
			{
				$arrColumns[$strColumn] = $this->column_view[$strColumn];
			}
		}

		//Query
		$strSQL = $this->_calcquery($arrColumns, $where, $order);
		$this->db->setQuery( $strSQL );
		$rows = $this->db->loadRowList();
		return $rows;
	}

	function getViewHeader($columns)
	{
	    $retval = array();
		while (list($strKey,$strColumn) = each($columns))
		{
			$retval[$strColumn] = $this->column_view[$strColumn];
		}
		return $retval;
	}

	function showlist($order="", $where="")
	{
		global $mainframe;

		$uri = JFactory::getURI();
		$option = $uri->getVar('option');
		$user =& JFactory::getUser();
		$limit = $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );

		// Read Filter
		$filterval = array();
		if (count($this->filter) > 0)
		{
			for ($i=0, $n=count( $this->filter ); $i < $n; $i++)
			{
				list ($fname, $ftype, $ffield, $fvaluelist) = $this->filter[$i];
				$filterval[$fname] = $mainframe->getUserStateFromRequest( $option.".".$fname, $fname, "", "string");
				if (($ftype == "select") && ($filterval[$fname] == ""))
				{
					$filterval[$fname] = "-1";
				}
				if (($filterval[$fname] == "NULL") || ($filterval[$fname] == "NOT NULL"))
				{
					if ($where != "") $where .= " AND ";
					$where .= $ffield." IS ".$filterval[$fname];
				}
				else
				{
					switch (strtolower($ftype))
					{
						case "text":
							if ($filterval[$fname] != "")
							{
								$fwhere = "";
								$fieldList = split(";",$ffield);
								reset($fieldList);
								foreach ($fieldList as $entry)
								{
									if ($fwhere != "") $fwhere .= " OR ";
									$fwhere .= $entry." LIKE \"%".$this->db->getEscaped( $filterval[$fname], true )."%\"";
								}
								if ($where != "") $where .= " AND ";
								$where .= "(".$fwhere.")";
							}
							break;
						case "select":
							if ($filterval[$fname] != "-1")
							{
								if ($where != "") $where .= " AND ";
								$where .= $ffield." = \"".$this->db->getEscaped( $filterval[$fname], true )."\"";
							}
							break;
					}
				}
			}
		}

		// Page-Navigation: Get the total number of records
		$strSQL = "SELECT COUNT(*) FROM `".$this->table."`";
		if ($where != "") $strSQL .= " WHERE ".$where;
		$this->db->setQuery( $strSQL );
		$total = $this->db->loadResult();
		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );

		// Order
		$filter_order = $mainframe->getUserStateFromRequest( "$option.filter_order", 'filter_order', '', 'cmd' );
		$filter_order_Dir = $mainframe->getUserStateFromRequest( "$option.filter_order_Dir", 'filter_order_Dir', '', 'word' );
		if ($filter_order != "")
		{
			$order = $filter_order .' '. $filter_order_Dir;
		}
		if ($order == "")
		{
			$order = $this->default_order["list"];
		}

		//Query
		$strSQL = $this->_calcquery($this->column_list, $where, $order, $this->getSetting("Primary_Key"));
		$strSQL = $strSQL . " LIMIT ".$pageNav->limitstart." , ".$pageNav->limit;
		$this->db->setQuery( $strSQL );
		$rows = $this->db->loadRowList();
		
		//Init HTML
		JHTML::_('behavior.tooltip');
		echo "<form action=\"index.php?option=" . $option . "\" method=\"post\" name=\"adminForm\">\n";

		// Display Filter
		if (count($this->filter) > 0)
		{
			echo "<table>\n";
			echo "\t<tr>\n";
			echo "\t\t<td width=\"100%\">".JText::_("FILTER_LABEL")."</td>\n";
			for ($i=0, $n=count( $this->filter ); $i < $n; $i++)
			{
				list ($fname, $ftype, $ffield, $fvaluelist) = $this->filter[$i];
				echo "\t\t<td nowrap=\"nowrap\">\n";
				switch (strtolower($ftype))
				{
					case "text":
						echo "\t\t\t<input type=\"text\" name=\"".$fname."\" id=\"".$fname."\" value=\"".$filterval[$fname]."\" class=\"text_area\" onchange=\"document.adminForm.submit();\" />\n";
						echo "\t\t\t<button onclick=\"this.form.submit();\">".JText::_( 'GO' )."</button>\n";
						echo "\t\t\t<button onclick=\"document.getElementById('search').value='';this.form.submit();\">".JText::_( 'RESET' )."</button>\n";
						break;
					case "select":
						echo "\t\t\t<select name=\"".$fname."\" id=\"".$fname."\" class=\"inputbox\" size=\"1\" onchange=\"document.adminForm.submit( );\">\n";
						while (list($value, $text) = each($fvaluelist))
						{
							echo "<option value=\"".$value."\"";
							if ($filterval[$fname] == $value)
							{
								echo " selected=\"selected\"";
							}
							echo ">".JText::_($text)."</option>\n";
						}
						echo "\t\t\t</select>\n";
						break;
				}
				echo "\t\t</td>\n";
			}
			echo "\t</tr>\n";
			echo "</table>\n";
		}

		//List-Header
		echo "<table class=\"adminlist\">\n";
		echo "<thead><tr>";
		reset($this->column_list);
		echo "<th width=\"10\">" . JText::_( 'NUM' ) . "</th>";
		echo "<th width=\"10\"><input type=\"checkbox\" name=\"toggle\" value=\"\" onclick=\"checkAll(" . count( $rows ) . ");\" /></th>";
		while (list($strColumn,$strTitle) = each($this->column_list))
		{
			echo "<th>";
			echo JHTML::_('grid.sort', $strTitle, $strColumn, $filter_order_Dir, $filter_order);
			echo "</th>";
		}
		
		echo "</tr></thead>\n";
		echo "<tfoot><tr><td colspan=\"" . (count($this->column_list) + 2) . "\">";
		echo $pageNav->getListFooter();
		echo "</td>";
		echo "</tr>";
		echo "</tfoot>\n";
		
		//List
		echo "<tbody>";
		for ($i=0, $n=count( $rows ); $i < $n; $i++)
		{
			$row = $rows[$i];
			$id = array_shift($row);
			$link = $this->_calc_url($this->getSetting("Command_Show"),$id);
			//$published 	= JHTML::_('grid.published', $row, $i );
			echo "<tr class=\"row". ($i % 2). "\">";
			echo "<td align=\"center\">";
			if (  JTable::isCheckedOut($user->get ('id'), $row->checked_out ) )
			{
				echo $pageNav->getRowOffset( $i );
			}
			else
			{
				echo "<span class=\"editlinktip hasTip\" title=\"" . JText::_( 'DETAILS' ) . "\">";
				echo "<a href=\"" . $link . "\">" . $pageNav->getRowOffset( $i ) . "</a></span>\n";
			}
			echo "</td>";
			echo "<td><input type=\"checkbox\" id=\"cb" . $i . "\" name=\"cid[]\" value=\"" . $id . "\" onclick=\"isChecked(this.checked);\" /></td>";
			reset($this->column_list);
			$rp=0;
			while (list($strColumn,$strTitle) = each($this->column_list))
			{
				$field = $row[$rp];
				echo "<td>";
				echo $this->_displayField($strColumn,$field,$i);
				echo "</td>";
				$rp++;
			}
			echo "<td>";
			echo "</tr>\n";
		}
		echo "</tbody></table>\n";
		echo "<input type=\"hidden\" name=\"option\" value=\"" . $option . "\" />\n";
		echo "<input type=\"hidden\" name=\"" . $this->getSetting("Object_Parameter") . "\" value=\"" . $this->getObjectName() . "\" />\n";
		echo "<input type=\"hidden\" name=\"task\" value=\"\" />\n";
		echo "<input type=\"hidden\" name=\"boxchecked\" value=\"0\" />\n";
		echo "<input type=\"hidden\" name=\"filter_order\" value=\"" . $lists['order'] . "\" />\n";
		echo "<input type=\"hidden\" name=\"filter_order_Dir\" value=\"" . $lists['order_Dir'] . "\" />\n";
		//echo "<input type=\"hidden\" name=\"" . $this->getSetting("PrimaryKey_Parameter") . "\" value=\"" . $id . "\" />\n";
		echo "<input type=\"hidden\" name=\"" . $this->getSetting("PrimaryKey_Parameter") . "\" value=\"\" />\n";
		echo JHTML::_( 'form.token' );
		echo "</form>\n";
	}

	function edit($id=0, $cols=array(), $posturl="")	// $id -1=Reedit 0=New >1=Edit
	{
		if (count($cols) < 1) $cols = $this->column_edit;
		$uri = JFactory::getURI();
		$option = $uri->getVar('option');
		if ($posturl == "") $posturl = "index.php?option=" . $option;

		// Header
		JHTML::_('behavior.tooltip');
		JHTML::_('behavior.calendar');

		// Validator JavaScript
		echo "<script language=\"javascript\" type=\"text/javascript\">\n";
		echo "function submitbutton(pressbutton) {\n";
		echo "	var form = document.adminForm;\n";
		echo "	var bSubmit = true;\n";
		echo "	if (pressbutton == 'cancel') {\n";
		echo "		submitform( pressbutton );\n";
		echo "		return;\n";
		echo "	}\n";
		reset($cols);
		while (list($strColumn,$strTitle) = each($cols))
		{
			if ($this->column_req[$strColumn])
			{
				echo "	if (form." . $strColumn . ".value == '') {\n";
				echo "		alert( \"" . JText::sprintf( 'ERROR_REQUIRED_COLUMN_EMPTY', $cols[$strColumn]) ."\" );\n";
				echo "		bSubmit = false;\n";
				echo "	}\n";
			}
			$rep = $this->column_rep[$strColumn];
			switch (strtolower($rep[0]))
			{
				case "email":
					echo "	if (bSubmit && (form." . $strColumn . ".value != '') && (!form." . $strColumn . ".value.match('^[^@\\\\s]+@[-a-z0-9]+\\.+[a-z]{2,}$'))) {\n";
					echo "		alert( \"" . JText::sprintf( 'ERROR_INVALID_EMAIL_ADDRESS', $cols[$strColumn], $rep[2]) ."\" );\n";
					echo "		bSubmit = false;\n";
					echo "	}\n";
					break;
				case "url":
					echo "	if ((form." . $strColumn . ".value != '') && (!form." . $strColumn . ".value.match('^https?://'))) {\n";
					echo "		form." . $strColumn . ".value = 'http://'+form." . $strColumn . ".value;\n";
					echo "	}\n";
					echo "	if (bSubmit && (form." . $strColumn . ".value != '') && (!form." . $strColumn . ".value.match('^https?://[a-z0-9-]+(\\.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$'))) {\n";
					echo "		alert( \"" . JText::sprintf( 'ERROR_INVALID_URL', $cols[$strColumn], $rep[2]) ."\" );\n";
					echo "		bSubmit = false;\n";
					echo "	}\n";
					break;
			}
		}
		echo "	if (bSubmit) {\n";
		echo "		submitform( pressbutton );\n";
		echo "	}\n";
		echo "}\n";
		echo "</script>\n";
		echo "<form action=\"" . $posturl . "\" method=\"post\" name=\"adminForm\">\n";
		echo "<div class=\"col100\">\n";
		echo "<fieldset class=\"adminform\">\n";
		echo "<legend>" . JText::_( 'DETAILS' ) . "</legend>\n";
		echo "<table class=\"admintable\">\n";

		if ($id > 0) {
			//Query
			$strSQL = $this->_calcquery($cols, "`".$this->getSetting("Primary_Key")."`=".$id, "");
			$this->db->setQuery( $strSQL );
			$rows = $this->db->loadRowList();
			$row = $rows[0];
		}

		// Display
		reset($cols);
		$fldCount = 0;
		while (list($strColumn,$strTitle) = each($cols))
		{
			echo "<tr><td class=\"key\">" . $strTitle . ":</td><td>";
			if ($id > 0)
			{
				echo $this->_editField($strColumn,$row[$fldCount]);
			}
			else
			{
				if ($id == -1)
				{
					echo $this->_editField($strColumn,JRequest::getVar($strColumn));
				}
				else
				{
					echo $this->_editField($strColumn,"");
				}
			}
			echo "</td></tr>\n";
			$fldCount = $fldCount + 1;
		}

		//Footer
		echo "</table>\n";
		echo "</fieldset>\n";
		echo "</div>\n";
		echo "<div class=\"clr\"></div>\n";
		echo "<input type=\"hidden\" name=\"option\" value=\"" . $option . "\" />\n";
		echo "<input type=\"hidden\" name=\"" . $this->getSetting("Object_Parameter") . "\" value=\"" . $this->getObjectName() . "\" />\n";
		echo "<input type=\"hidden\" name=\"task\" value=\"\" />\n";
		if ($id == -1) $id = JRequest::getVar($this->getSetting("Primary_Key"));
		echo "<input type=\"hidden\" name=\"" . $this->getSetting("PrimaryKey_Parameter") . "\" value=\"" . $id . "\" />\n";
		echo "<input type=\"hidden\" name=\"" . $this->getSetting("Primary_Key") . "\" value=\"" . $id . "\" />\n";
		echo JHTML::_( 'form.token' );
		echo "</form>\n";
	}

	function save($id=0, $cols=array())
	{
		if (count($cols) < 1) $cols = $this->column_edit;

		$uri = JFactory::getURI();
		$option = $uri->getVar('option');

		//Check Mandatory fields
		reset($this->column_req);
		while (list($strColumn,$strReqFlg) = each($this->column_req))
		{
			if ((JRequest::getVar($strColumn) == "") && ($cols[$strColumn] != ""))
			{
				nokCM_error(JText::sprintf( 'ERROR_REQUIRED_COLUMN_EMPTY', $cols[$strColumn]), false);
				return;
			}
		}

		//Check fields for their type
		reset($cols);
		while (list($strColumn,$strTitle) = each($cols))
		{
			$rep = $this->column_rep[$strColumn];
			$cvalue = JRequest::getVar($strColumn);
			switch (strtolower($rep[0]))
			{
				case "email":
					if ($cvalue != "") {
						if (!preg_match('/^[^@\s]+@([-a-z0-9]+\.)+[a-z]{2,}$/i', $cvalue))
						{
							nokCM_error(JText::sprintf( 'ERROR_INVALID_EMAIL-ADDRESS', $cols[$strColumn], $rep[2]), false);
							return;
						}
						$length = strlen($cvalue);
						if ($rep[2] && ($length > $rep[2]))
						{
							nokCM_error(JText::sprintf( 'ERROR_COLUMN_TOO_BIG', $cols[$strColumn], $rep[2]), false);
							return;
						}
						$values[$strColumn] = "'" . addslashes($cvalue) . "'";
					}
					else
					{
						$values[$strColumn] = "NULL";
					}
					break;
				case "url":
					if ($cvalue != "")
					{
						if (!preg_match('|^https?://|i', $cvalue))
						{
							// Add prefix if missing.
							$cvalue = 'http://' . $cvalue;
						}
						if (!preg_match('|^https?://[a-z0-9-]+(\.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $cvalue))
						{
							nokCM_error(JText::sprintf( 'ERROR_INVALID_URL', $cols[$strColumn], $rep[2]), false);
							return;
						}
						$length = strlen($cvalue);
						if ($rep[2] && ($length > $rep[2]))
						{
							nokCM_error(JText::sprintf( 'ERROR_COLUMN_TOO_BIG', $cols[$strColumn], $rep[2]), false);
							return;
						}
						$values[$strColumn] = "'" . addslashes($cvalue) . "'";
					}
					else
					{
						$values[$strColumn] = "NULL";
					}
					break;
				case "category":
				case "selection":
					if ($cvalue != "")
					{
						$values[$strColumn] = intval($cvalue);
					}
					else
					{
						$values[$strColumn] = "NULL";
					}
					break;
				case "readonly":
					if ($id != "" && $id != 0)
					{
						$default = $rep[3];
					}
					else
					{
						$default = $rep[2];
					}
					switch (strtolower($default))
					{
						case "currentuser":
							$user =& JFactory::getUser(); 
							$values[$strColumn] = "'" . addslashes($user->get('name')) . "'";
							break;
						case "currentdate":
							$values[$strColumn] = "NOW()";
							break;
						case "currentip":
							$values[$strColumn] = "'" . addslashes($_SERVER['REMOTE_ADDR']) . "'";
							break;
						case "currenthost":
							$values[$strColumn] = "'" . addslashes($_SERVER['REMOTE_HOST']) . "'";
							break;
						default:
							break;
					}
					break;
				case "text":
					if ($cvalue != "")
					{
						$length = strlen($cvalue);
						if ($rep[2] && ($length > $rep[2]))
						{
							nokCM_error(JText::sprintf( 'ERROR_COLUMN_TOO_BIG', $cols[$strColumn], $rep[2]), false);
							return;
						}
						$values[$strColumn] = "'" . addslashes($cvalue) . "'";
					}
					else
					{
						$values[$strColumn] = "NULL";
					}
					break;
				case "datetime":
					if ($cvalue != "")
					{
						$config =& JFactory::getConfig();
						$date = JFactory::getDate( $cvalue, -$config->getValue('config.offset' ));
						$values[$strColumn] = "'" . addslashes($date->toMySQL()) . "'";
					}
					else
					{
						$values[$strColumn] = "NULL";
					}
					break;
				case "date":
					if ($cvalue != "")
					{
						$config =& JFactory::getConfig();
						$date = JFactory::getDate( $cvalue );
						$values[$strColumn] = "'" . addslashes($date->toMySQL()) . "'";
					}
					else
					{
						$values[$strColumn] = "NULL";
					}
					break;
				default:
					if ($cvalue != "")
					{
						$values[$strColumn] = "'" . addslashes($cvalue) . "'";
					}
					else
					{
						$values[$strColumn] = "NULL";
					}
					break;
			}
		}

		if ($id != "" && $id != 0)
		{
			//Update
			$strSQL = "UPDATE `" . $this->table . "` SET ";
			$booFirst = true;
			reset($values);
			while (list($strColumn,$strValue) = each($values))
			{
				if ($booFirst)
				{
					$booFirst = false;
				}
				else
				{
					$strSQL = $strSQL . ", ";
				}
				$strSQL = $strSQL . $strColumn . "=" . $strValue;
			}
			$strSQL = $strSQL . " WHERE " . $this->getSetting("Primary_Key") . "=" . $id;
		}
		else
		{
			//Insert
			$collist = "";
			$vallist = "";
			reset($values);
			while (list($strColumn,$strValue) = each($values))
			{
				if ($collist != "")
				{
					$collist = $collist . ",";
				}
				$collist = $collist."`".$strColumn."`";
				if ($vallist != "")
				{
					$vallist = $vallist . ",";
				}
				$vallist = $vallist . $strValue;
			}
			$strSQL = "INSERT INTO `" . $this->table . "` (" . $collist . ") VALUES (" . $vallist . ")";
		}
		$this->db->setQuery( $strSQL );
		if (!$this->db->query())
		{
			nokCM_error(JText::sprintf( 'ERROR_DATABASE_QUERY', $this->db->getErrorMsg(true)), false);
			return;
		}
		if (!$id)
		{
			$strSQL = "SELECT `" . $this->getSetting("Primary_Key") . "` FROM `" . $this->table . "` WHERE ";
			$booFirst = true;
			reset($values);
			while (list($strColumn,$strValue) = each($values))
			{
				if ($booFirst)
				{
					$booFirst = false;
				}
				else
				{
					$strSQL = $strSQL . " AND ";
				}
				if ($strValue == "NULL")
				{
					$strSQL = $strSQL."`".$strColumn."` IS " . $strValue;
				}
				else
				{
					$strSQL = $strSQL."`".$strColumn."`=" . $strValue;
				}
			}
			$this->db->setQuery( $strSQL );
			$id = $this->db->loadResult();
		}
		return $id;
	}

	function showdetail($id, $cols=array())
	{
		if (count($cols) < 1) $cols = $this->column_show;
		$uri = JFactory::getURI();
		$option = $uri->getVar('option');

		// Header
		JHTML::_('behavior.tooltip');
		echo "<form action=\"index.php?option=" . $option . "\" method=\"post\" name=\"adminForm\">\n";
		echo "<div class=\"col100\">\n";
		echo "<fieldset class=\"adminform\">\n";
		echo "<legend>" . JText::_( 'DETAILS' ) . "</legend>\n";
		echo "<table class=\"admintable\">\n";

		//Query
		$strSQL = $this->_calcquery($cols, "`".$this->getSetting("Primary_Key")."`=".$id, "");
		$this->db->setQuery( $strSQL );
		$rows = $this->db->loadRowList();
		$row = $rows[0];

		// Display
		reset($cols);
		$fldCount = 0;
		while (list($strColumn,$strTitle) = each($cols))
		{
			echo "<tr><td class=\"key\">" . $strTitle . "</td><td>";
			echo $this->_displayField($strColumn,$row[$fldCount]);
			echo "</td></tr>\n";
			$fldCount = $fldCount + 1;
		}

		//Footer
		echo "</table>\n";
		echo "</fieldset>\n";
		echo "</div>\n";
		echo "<div class=\"clr\"></div>\n";
		echo "<input type=\"hidden\" name=\"option\" value=\"" . $option . "\" />\n";
		echo "<input type=\"hidden\" name=\"" . $this->getSetting("Object_Parameter") . "\" value=\"" . $this->getObjectName() . "\" />\n";
		echo "<input type=\"hidden\" name=\"task\" value=\"\" />\n";
		echo "<input type=\"hidden\" name=\"boxchecked\" value=\"1\" />\n";
		echo "<input type=\"hidden\" name=\"cid[]\" value=\"" . $id . "\" />\n";
		echo "<input type=\"hidden\" name=\"id\" value=\"" . $id . "\" />\n";
		echo JHTML::_( 'form.token' );
		echo "</form>\n";
	}

	function delete($id)
	{
		global $mainframe;

		// Check delete rules
		$localCols = array();
		foreach ($this->delete_rule as $rule)
		{
			$localCols[] = $rule[1];
		}
		$localCols = array_unique($localCols);
		$localData = array();
		if ((count($localCols) == 1) && ($localCols[0] == $this->getSetting("Primary_Key")))
		{
			$localData[$this->getSetting("Primary_Key")] = $id;
		}
		else
		{
			if (count($localCols) > 0)
			{
				$collist = implode("`,`",$localCols);
				$strSQL = "SELECT `".$collist."` FROM ".$this->table;
				$strSQL .= " WHERE `".$this->getSetting("Primary_Key")."`='".$id."'";
				$this->db->setQuery( $strSQL );
				$rows = $this->db->loadRowList();
				$rowcount = count($rows);
				if ($rowcount == 1)
				{
					$row = $rows[0];
					for ($i=0, $n=count( $localCols ); $i < $n; $i++)
					{
						$localData[$localCols[$i]] = $row[$i];
					}
				}
			}
		}
		foreach ($this->delete_rule as $rule)
		{
			switch(strtolower($rule[0]))
			{
				case "check":
					$strSQL = "SELECT COUNT(*) FROM `".$rule[2]."` WHERE `".$rule[3]."`='".$localData[$rule[1]]."'";
					$this->db->setQuery( $strSQL );
					$rows = $this->db->loadRowList();
					if ($rows === false)
					{
						nokCM_error(JText::sprintf( 'ERROR_DATABASE_QUERY', $this->db->getErrorMsg(true)));
					}
					else
					{
						if ($rows[0][0] > 0)
						{
							nokCM_error(JText::_("DELETE_CONSITENCY_ERROR"));
							return;
						}
					}
					break;
				case "delete":
					$strSQL = "DELETE FROM `".$rule[2]."` WHERE `".$rule[3]."`='".$localData[$rule[3]]."'";
					$this->db->setQuery( $strSQL );
					if (!$this->db->query())
					{
						nokCM_error(JText::sprintf( 'ERROR_DATABASE_QUERY', $this->db->getErrorMsg(true)));
					}
					break;
			}
		}
		$strSQL = "DELETE FROM `".$this->table . "` WHERE " . $this->getSetting("Primary_Key");
		if (is_array($id))
		{
			$strSQL = $strSQL . " IN (" . implode( ',', $id ) . ")";
		}
		else
		{
			$strSQL = $strSQL . "=" . $id;
		}
		$this->db->setQuery( $strSQL );
		if (!$this->db->query())
		{
			nokCM_error(JText::sprintf( 'ERROR_DATABASE_QUERY', $this->db->getErrorMsg(true)));
		}
		$url = $this->_calc_url($this->getSetting("Command_List"));
		$error = $this->db->getErrorMsg();
		if($error)
		{
			$mainframe->redirect($url,JText::sprintf("DELETE_ERROR",$error));
		}
		else
		{
			$mainframe->redirect($url,JText::_("DELETED_SUCCESSFULLY"));
		}
	}

	function export($order="", $where="")
	{
		//Header
		JHTML::_('behavior.tooltip');
		echo "<script language=\"JavaScript\">\n";
		echo "var wCsvOut;\n";
		echo "\n";
		echo "function transferCSV() {\n";
		echo "	oTable = document.getElementById(\"exportlist\");\n";
		echo "	arrRows = oTable.rows;\n";
		echo "	iNumOfRows = arrRows.length;\n";
		echo "	if (iNumOfRows > 0) { iNumOfCells =  arrRows[0].cells.length; }\n";
		echo "	var arrRowCsv = [iNumOfRows];\n";
		echo "\n";
		echo "	for (var iRow = 0; iRow < iNumOfRows; iRow++) {\n";
		echo "		strCvsRow = \"\";\n";
		echo "		for (var iCell = 0; iCell < iNumOfCells; iCell++) {\n";
		echo "			if (iCell < iNumOfCells-1) {\n";
		echo "				strCvsRow += arrRows[iRow].cells[iCell].innerHTML + \";\";\n";
		echo "			} else {\n";
		echo "				strCvsRow += arrRows[iRow].cells[iCell].innerHTML + \"\\n\";\n";
		echo "			}\n";
		echo "		}\n";
		echo "		arrRowCsv[iRow] = strCvsRow;\n";
		echo "	}\n";
		echo "	if (document.all) {\n";
		echo "		//IE\n";
		echo "		wCsvOut = window.document.open(\"text/csv\");\n";
		echo "		for (var iRow = 0; iRow < iNumOfRows; iRow++) {\n";
		echo "			wCsvOut.write(arrRowCsv[iRow]);\n";
		echo "		}\n";
		echo "		wCsvOut.execCommand('SaveAs', null, 'output.csv');\n";
		echo "		wCsvOut.close();\n";
		echo "	} else {\n";
		echo "		wCsvOut = window.document.open(\"about:blank\",\"Export\");\n";
		echo "		for (var iRow = 0; iRow < iNumOfRows; iRow++) {\n";
		echo "			wCsvOut.write(arrRowCsv[iRow]);\n";
		echo "		}\n";
		echo "		//netscape.security.PrivilegeManager.enablePrivilege(\"UniversalXPConnect\");\n";
		echo "		//saveDocument(wCsvOut.document);\n";
		echo "		//wCsvOut.close();\n";
		echo "	}\n";
		echo "}\n";
		echo "</script>\n";
		echo "<form action=\"index.php?option=" . $option . "\" method=\"post\" name=\"adminForm\">\n";

		echo "<table class=\"adminlist\" id=\"exportlist\">\n";
		echo "<thead><tr>";
		$this->db->setQuery("Describe ".$this->table);
		$rows = $this->db->loadResultArray();
		$cols = array();
		while (list($key, $field) = each($rows))
		{
			if (substr($field,0,1) != "_")
			{
				echo "<th>" . $field . "</th>";
				$cols[] = $field;
			}
		}
		echo "</tr></thead>\n";

		//$strSQL = $this->_calcquery($this->column_export, $where, $order, $this->getSetting("Primary_Key"));
		$collist = implode(",",$cols);
		$strSQL = "SELECT ".$collist." FROM ".$this->table;
		if ($where != "") $strSQL .= " WHERE ".$where;
		if ($order != "") $strSQL .= " ORDER BY ".$order;

		$this->db->setQuery( $strSQL );
		$rows = $this->db->loadRowList();
		$rowcount = count($rows);
		if ($rowcount > 0)
		{
			//List
			echo "<tbody>";
			for ($i=0; $i < $rowcount; $i++)
			{
				$row = $rows[$i];
				echo "<tr class=\"row". ($i % 2). "\">";
				foreach ($row as $field)
				{
					echo "<td>" . $field . "</td>";
				}
				echo "<td>";
				echo "</tr>\n";
			}
			echo "</tbody>";
		}
		echo "</table>\n";

		//Footer
		echo "<input type=\"hidden\" name=\"option\" value=\"" . $option . "\" />\n";
		echo "<input type=\"hidden\" name=\"" . $this->getSetting("Object_Parameter") . "\" value=\"" . $this->getObjectName() . "\" />\n";
		echo "<input type=\"hidden\" name=\"task\" value=\"\" />\n";
		echo "<input type=\"hidden\" name=\"boxchecked\" value=\"0\" />\n";
		echo "<input type=\"hidden\" name=\"filter_order\" value=\"" . $lists['order'] . "\" />\n";
		echo "<input type=\"hidden\" name=\"filter_order_Dir\" value=\"" . $lists['order_Dir'] . "\" />\n";
		echo "<input type=\"hidden\" name=\"" . $this->getSetting("PrimaryKey_Parameter") . "\" value=\"\" />\n";
		echo JHTML::_( 'form.token' );
		echo "</form>\n";

		if ($rowcount > 0)
		{
			// Export links
			echo "<p align=\"center\">\n";
			echo "<input type=\"button\" value=\"CSV\" onClick=\"javascript:transferCSV();\">\n";
			echo "</p>\n";
		}
	}

	function import_form() {
		$uri = JFactory::getURI();
		$option = $uri->getVar('option');

		echo "<form enctype=\"multipart/form-data\" action=\"index.php\" method=\"post\" name=\"adminForm\">\n";
		echo "<table class=\"adminlist\" id=\"exportlist\">\n";
		echo "<tbody>\n";
		echo "<tr><th>" . JText::_("IMPORT FILE LABEL"). "</th>";
		echo "<td><input class=\"inputbox\" id=\"import_file\" name=\"import_file\" type=\"file\" size=\"50\" /></td></tr>\n";
		echo "<tr><th>" . JText::_("IMPORT TEXT LABEL"). "</th>";
		echo "<td><textarea class=\"inputbox\" name=\"import_text\" cols=\"50\" rows=\"10\" id=\"import_text\"></textarea></td></tr>\n";
		echo "<tr><th/><td><input class=\"button\" type=\"button\" value=\"".JText::_("IMPORT BUTTON")."\" onclick=\"submitbutton()\" /></td></tr>\n";
		echo "</tbody>\n";
		echo "</table>\n";

		//Footer
		echo "<input type=\"hidden\" name=\"option\" value=\"" . $option . "\" />\n";
		echo "<input type=\"hidden\" name=\"" . $this->getSetting("Object_Parameter") . "\" value=\"" . $this->getObjectName() . "\" />\n";
		echo "<input type=\"hidden\" name=\"task\" value=\"\" />\n";
		echo JHTML::_( 'form.token' );
		echo "</form>\n";
	}

	function import_do($csvtext) {
	}

	function _command_link($setting, $text, $id="")
	{
		return "<a href=\"" . $this->_calc_url($this->getSetting($setting),$id) . "\">" . JText::_($text) . "</a>";
	}

	function _calc_url($command, $id="")
	{
		$uri = JFactory::getURI();
		$uri->setVar($this->getSetting("Command_Parameter"),$command);
		$uri->setVar($this->getSetting("Object_Parameter"),$this->objectname);
		if ($id != "") $uri->setVar($this->getSetting("PrimaryKey_Parameter"),$id);
		return $uri->toString();
	}

	function _displayField($strColumn, $strValue, $intPosition=-1)
	{
		$rep = $this->column_rep[$strColumn];
		switch (strtolower($rep[0]))
		{
			case "category":
			    $section = "nokCM_" . $rep[1];
				$rep[0] = "selection";
				$rep[1] = "id";
				$rep[2] = "name";
				$rep[3] = "#__categories";
				$rep[4] = "section='" . $section . "' AND published=1 AND access<=" . $this->gid;
				break;
			case "readonly":
				$rep[0] = $rep[1];
				break;
		}
		switch (strtolower($rep[0]))
		{
			case "email":
				if ($strValue != "")
				{
					return "<A HREF=\"mailto:" . $strValue . "\">" . $strValue . "</A>";
				}
				return "";
				break;
			case "url":
				if ($strValue != "")
				{
					return "<A HREF=\"" . $strValue . "\">" . $strValue . "</A>";
				}
				return "";
				break;
			case "checkbox":
				if (($strValue == "") || ($strValue == "0") || (strtolower($strValue) == "n") || (strtolower($strValue) == "false"))
				{
					return JText::_("NO");
				}
				else
				{
					return JText::_("YES");
				}
				break;
			case "date":
				if ($strValue != "")
				{
					return JHTML::_('date', $strValue, JText::_('DATE_FORMAT_LC'));
				}
				break;
			case "datetime":
				if ($strValue != "")
				{
					$config =& JFactory::getConfig();
					$date = JFactory::getDate( $strValue );
					$date->setOffset( -$config->getValue('config.offset' ));
					return JHTML::_('date', $date->toFormat(), JText::_('DATE_FORMAT_LC2'));
				}
				break;
			case "password":
				return "********";
				break;
			case "selection":
				if ($strValue>0)
				{
					$strSQL = "SELECT " . $rep[2] . " FROM `". $rep[3] . "` WHERE " . $rep[1] . "='" . $strValue . "'";
					if ($rep[4] != "") $strSQL = $strSQL . " AND " . $rep[4];
					$this->db->setQuery( $strSQL );
					$strSelectionValue = $this->db->loadResult();
					return $strSelectionValue;
				}
				else
				{
					return "&nbsp;";
				}
				break;
			case "textselect":
				$aDefList = split(";",$rep[1]);
				reset($aDefList);
				foreach ($aDefList as $entry)
				{
					$aDef = split("=",$entry,2);
					if ($aDef[0] == $strValue)
					{
						return JText::_($aDef[1]);
					}
				}
				return JText::_($strValue);
				break;
			case "publish":
				if ($intPosition == -1)
				{
					//Display
					if (($strValue == "") || ($strValue == "0") || (strtolower($strValue) == "n") || (strtolower($strValue) == "false"))
					{
						return JText::_("NO");
					}
					else
					{
						return JText::_("YES");
					}
				}
				else
				{
					//List
					if (($strValue == "") || ($strValue == "0") || (strtolower($strValue) == "n") || (strtolower($strValue) == "false"))
					{
						return "<a href=\"javascript:void(0);\" onclick=\"return listItemTask('cb".$intPosition."','publish')\" title=\"".JText::_("PUBLISH ITEM")."\"><img src=\"images/publish_x.png\" border=\"0\" alt=\"".JText::_("UNPUBLISHED")."\" /></a>";
					}
					else
					{
						return "<a href=\"javascript:void(0);\" onclick=\"return listItemTask('cb".$intPosition."','unpublish')\" title=\"".JText::_("UNPUBLISH ITEM")."\"><img src=\"images/tick.png\" border=\"0\" alt=\"".JText::_("PUBLISHED")."\" /></a>";
					}
				}
				break;
			case "image":
				if ($strValue != "")
				{
					return "<img src=\"".$rep[1]."/".$strValue."\">";
				}
				break;
			case "readonly":
			case "text":
			default:
				return $strValue;
				break;
		}
	}

	function publish ($cid)
	{
		$this->changePublish ($cid, 1);
	}

	function unpublish ($cid)
	{
		$this->changePublish ($cid, 0);
	}

	function changePublish ($cid, $state)
	{
		$cids = implode( ',', $cid );
		$strSQL = "UPDATE `".$this->getTable()."`"
		. " SET published = ".(int) $state
		. " WHERE id IN ( ". $cids ." )";
		$this->db->setQuery( $strSQL );
		if (!$this->db->query())
		{
			JError::raiseError(500, $this->db->getErrorMsg() );
		}
	}

	function _editField($strColumn, $strValue)
	{
		$strRet = "";
		$rep = $this->column_rep[$strColumn];
//		if ($this->column_req[$strColumn])
//		{
//			$class = "required";
//		}
//		else
//		{
			$class = "inputbox";
//		}
		switch (strtolower($rep[0]))
		{
			case "category":
			    $section = "nokCM_" . $rep[1];
				$rep[0] = "selection";
				$rep[1] = "id";
				$rep[2] = "name";
				$rep[3] = "#__categories";
				$rep[4] = "section='" . $section . "' AND published=1 AND access<=" . $this->gid;
				break;
		}
//echo "***".$rep[0]."***";
		switch (strtolower($rep[0]))
		{
			case "email":
			case "url":
			case "text":
				if ((strtolower($rep[0]) == "text") && ($rep[3] > 0))
				{
					//textarea
					$strRet .= "<textarea class=\"" . $class . "\" name=\"" . $strColumn . "\" cols=\"" . $rep[1] . "\" rows=\"" . $rep[3] . "\" id=\"" . $strColumn . "\">";
					$strRet .= $strValue . "</textarea>";
				}
				else
				{
					$strRet .= "<input class=\"" . $class . "\" type=\"text\" name=\"" . $strColumn . "\" id=\"" . $strColumn . "\" value=\"" . $strValue . "\"";
					if ($rep[1] != "") $strRet .= " size=\"" . $rep[1] . "\"";
					if ($rep[2] != "") $strRet .= " maxsize=\"" . $rep[2] . "\"";
					$strRet .= ">";
				}
				break;
			case "checkbox":
				$strRet .= JHTML::_('select.booleanlist',  $strColumn, "class=\"" . $class . "\"", $strValue );
				break;
			case "date":
				$cformat = str_replace("%y","%Y",JText::_('DATE_FORMAT_LC4'));
				$cformat_desc = $cformat;
				$cformat_desc = str_replace("%d","dd",$cformat_desc);
				$cformat_desc = str_replace("%m","mm",$cformat_desc);
				$cformat_desc = str_replace("%y","yy",$cformat_desc);
				$cformat_desc = str_replace("%Y","yyyy",$cformat_desc);
				if ($strValue != "")
				{
					$date =& JFactory::getDate($strValue);
					$strValue = $date->toFormat($cformat);
				}
				$strRet .= JHTML::_('calendar', $strValue, $strColumn, $strColumn, $format = $cformat, array('class'=>$class, 'size'=>'10',  'maxlength'=>'10'))." (".$cformat_desc.")";
				break;
			case "time":
				$strRet .= "<input class=\"" . $class . "\" type=\"text\" name=\"" . $strColumn . "\" id=\"" . $strColumn . "\" value=\"" . $strValue . "\"";
				$strRet .= " size=\"8\"";
				$strRet .= " maxsize=\"8\"";
				$strRet .= ">";
				break;
			case "datetime":
				$strRet .= JHTML::_('calendar', $strValue, $strColumn, $strColumn, '%Y-%m-%d %H:%M:%S', array('class'=>'inputbox', 'size'=>'19',  'maxlength'=>'19'));
				break;
			case "password":
				$strRet .= "<input class=\"" . $class . "\" type=\"password\" name=\"" . $strColumn . "\" id=\"" . $strColumn . "\" value=\"\"";
				if ($rep[1] != "") $strRet .= " size=\"" . $rep[1] . "\"";
				if ($rep[2] != "") $strRet .= " maxsize=\"" . $rep[2] . "\"";
				$strRet .= ">";
				break;
			case "selection":
				$strSQL = "SELECT `" . $rep[1] . "`, " . $rep[2] . " FROM `". $rep[3]."`";
				if ($rep[4] != "") $strSQL = $strSQL . " WHERE " . $rep[4];
				if ($rep[5] != "") $strSQL = $strSQL . " ORDER BY " . $rep[5];
				$this->db->setQuery( $strSQL );
				$rows = $this->db->loadRowList();
				$opt = array();
				if ($rep[6] != "")
				{
					// NULL Value
					$opt[] = JHTML::_("select.option",  "", $rep[6]);
				}
				foreach ($rows as $row)
				{
					$opt[] = JHTML::_("select.option",  $row[0], $row[1] );
				}
				$strRet .= JHTML::_('select.genericlist',   $opt, $strColumn, "class=\"" . $class . "\"", "value", "text", $strValue);
				break;
			case "textselect":
				unset($opt);
				if ($rep[2] != "")
				{
					// NULL Value
					$opt[] = JHTML::_("select.option",  "", $rep[2]);
				}
				$aDefList = split(";",$rep[1]);
				reset($aDefList);
				$bfound = false;
				foreach ($aDefList as $entry)
				{
					$aDef = split("=",$entry,2);
					$opt[] = JHTML::_("select.option",  $aDef[0], JText::_($aDef[1]));
				}
				$strRet .= JHTML::_('select.genericlist',   $opt, $strColumn, "class=\"" . $class . "\"", "value", "text", $strValue);
				break;
			case "publish":
				$strRet .= JHTML::_('select.booleanlist',  $strColumn, 'class="inputbox"', $strValue);
				break;
			case "readonly":
				$strRet .= $strValue;
				break;
			case 'image':
				jimport( 'joomla.filesystem.folder' );
				$files = JFolder::files(JPATH_SITE.DS.$rep[1]);
				$options = array(JHTML::_('select.option',  '', '- '. JText::_( 'SELECT IMAGE' ) .' -' ));
				$allowed_extensions =  "bmp|gif|jpg|png";
				foreach ( $files as $file )
				{
					if (eregi( $allowed_extensions, $file ))
					{
						$options[] = JHTML::_('select.option',  $file );
					}
				}

				$javascript = "onchange=\"javascript:";
				$javascript = $javascript."if (document.forms.adminForm.".$strColumn.".options[selectedIndex].value != '') {";
				$javascript = $javascript."document.forms.adminForm.img_".$strColumn.".src='".$rep[1]."/'+document.forms.adminForm.".$strColumn.".options[selectedIndex].value;";
				$javascript = $javascript."document.forms.adminForm.img_".$strColumn.".style.display = '';";
//				$javascript = $javascript."alert(document.forms.adminForm.".$strColumn.".options[selectedIndex].value);";
				$javascript = $javascript."} else {";
				$javascript = $javascript."document.forms.adminForm.img_".$strColumn.".style.display = 'none';";
//				$javascript = $javascript."alert('none');";
				$javascript = $javascript."}\"";
				$strRet .= JHTML::_('select.genericlist',  $options, $strColumn, 'class="inputbox" size="1" '. $javascript, 'value', 'text', $strValue);
				$style = "";
/*
				if ($strValue == "") {
					$style =" style=\"display: none;\"";
				}
*/
				$strRet .= "<img src=\"".$rep[1]."/".$strValue."\" name=\"img_".$strColumn."\" id=\"img_".$strColumn."\"".$style.">";
				break;
			default:
				$strRet .= $strValue;
				break;
		}
		if ($this->column_req[$strColumn])
		{
			$strRet .= " <span style=\"color:#FF0000\">*</span>";
		}
		return $strRet;
	}

	function menu ( $cmd, $option )
	{
//echo "***DEBUG: ".$cmd." ***\n";
		if (!$cmd) $cmd = "list";
		switch ($cmd)
		{
			case 'add':
				$this->edit();
				break;
			case 'edit':
				$cid = JRequest::getVar('cid', array(), '', 'array');
				JArrayHelper::toInteger($cid);
				if (empty( $cid ))
				{
					JError::raiseWarning( 500, 'No items selected' );
				}
				$this->edit($cid[0]);
				break;
			case 'remove':
				$cid = JRequest::getVar('cid', array(), '', 'array');
				JArrayHelper::toInteger($cid);
				if (empty( $cid ))
				{
					JError::raiseWarning( 500, 'No items selected' );
				}
				foreach ($cid as $id)
				{
					$this->delete($id);
				}
				break;
			case 'show':
				$cid = JRequest::getVar('cid', array(), '', 'array');
				JArrayHelper::toInteger($cid);
				if (empty( $cid ))
				{
					JError::raiseWarning( 500, 'No items selected' );
				}
				$this->showdetail($cid[0]);
				break;
			case 'list':
				$this->showlist();
				break;
			case 'apply':
				$cid = JRequest::getVar('cid', array(), '', 'array');
				JArrayHelper::toInteger($cid);
				$id = $this->save($cid[0]);
				if ($id>0)
				{
					$this->edit($id);
				}
				else
				{
					$this->edit(-1);
				}
				break;
			case 'save':
				$cid = JRequest::getVar('cid', array(), '', 'array');
				JArrayHelper::toInteger($cid);
				$id = $this->save($cid[0]);
				if ($id>0)
				{
					$this->showdetail($id);
				}
				else
				{
					$this->edit(-1);
				}
				break;
			case 'cancel':
				$this->showlist();
				break;
			case 'export':
				$this->export();
				break;
			case 'import':
				$csvtext = "";
				foreach ($_FILES as $file)
				{
					if ($file['tmp_name'] > '')
					{
						$csvtext .= file_get_contents($file['tmp_name']);
					}
				}
				$csvtext .= JRequest::getVar('csvtext');
				if ($csvtext == "")
				{
					$this->import_form();
				}
				else
				{
					$this->import_do($csvtext);
				}
				break;
			case 'publish':
				if ($this->column_rep['published'])
				{
					$cid = JRequest::getVar('cid', array(), '', 'array');
					JArrayHelper::toInteger($cid);
					if (empty( $cid ))
					{
						JError::raiseWarning( 500, 'No items selected' );
					}
					else
					{
						$this->publish($cid);
					}
				}
				$this->showlist();
				break;
			case 'unpublish':
				if ($this->column_rep['published'])
				{
					$cid = JRequest::getVar('cid', array(), '', 'array');
					JArrayHelper::toInteger($cid);
					if (empty( $cid ))
					{
						JError::raiseWarning( 500, 'No items selected' );
					}
					else
					{
						$this->unpublish($cid);
					}
				}
				$this->showlist();
				break;
			default:
				nokCM_error(JText::sprintf( 'ERROR_UNKNOWN_COMMAND', $cmd));
				break;
		}
	}
}
?>