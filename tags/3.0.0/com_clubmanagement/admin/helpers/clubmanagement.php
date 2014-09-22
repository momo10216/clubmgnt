<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Main
* @copyright	Copyright (c) 2014 Norbert Kümin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

defined('_JEXEC') or die;

class ClubManagementHelper extends JHelperContent
{
	public static function addSidebar($vName)
	{
		JHtmlSidebar::addEntry(
			JText::_('COM_CLUBMANAGEMENT_MENU_PERSONS'),
			'index.php?option=com_clubmanagement&view=persons',
			$vName == 'persons'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_CLUBMANAGEMENT_MENU_MEMBERSHIPS'),
			'index.php?option=com_clubmanagement&view=memberships',
			$vName == 'memberships'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_CLUBMANAGEMENT_MENU_BOARD'),
			'index.php?option=com_clubmanagement&view=boardentries',
			$vName == 'boardentries'
		);
	}

        public function exportData($model)
        {
		$export_columns = $model->getExportColumns();
		$known_fields = $model->getFieldMapping();
		$export_fields = array();
		foreach ($export_columns as $column)
		{
			$export_fields[$column] = $known_fields[$column];
		}

                $db = JFactory::getDBO();
                $query = $model->getExportQuery($export_fields);
 		$db->setQuery($query);
		$rows = $db->loadRowList();
		return array_merge(array(array_keys($export_fields)), $rows);
	}

        public function importData($model, $header, $data)
        {
		$known_fields = $model->getFieldMapping();
                $db = JFactory::getDBO();
		$userId = JFactory::getUser()->get('id');
		foreach ($data as $entry)
		{
			$row = self::getNamedArray($header,$entry);
			$row = self::resolveForeignKeys($model, $row);
			$id = self::findRecordWithPrimaryFields($model, $row);
			$query = $db->getQuery(true);
			if ($id)
			{
				// Update
				$fields = array();
				foreach(array_keys($row) as $key) {
					array_push($fields, $db->quoteName(substr($known_fields[$key],2))."=".$db->quote($row[$key]));
				}
				array_push($fields, $db->quoteName("modifieddate")."=".JFactory::getDate()->toSql());
				array_push($fields, $db->quoteName("modifiedby")."=".$userId);
				$query
					->update($db->quoteName($model->getTableName()))
					->set($fields)
					->where($db->quoteName($model->getIdFieldName()).'='.$id);
			}
			else
			{
				// Insert
				$fields = array();
				$values = array();
				foreach(array_keys($row) as $key) {
					$field = substr($known_fields[$key],2);
					array_push($fields, $db->quoteName($field));
					if (($field == "createddate") && (empty($row[$key]))) {
						$row[$key] = JFactory::getDate()->toSql();
					}
					if (($field == "createdby") && (empty($row[$key]))) {
						$row[$key] = $userId;
					}
					array_push($values, $db->quote($row[$key]));
				}
				if (!array_search("createddate",$fields)) {
					array_push($fields, $db->quoteName("createddate"));
					array_push($values, $db->quote(JFactory::getDate()->toSql()));
				}
				if (!array_search("createdby",$fields)) {
					array_push($fields, $db->quoteName("createdby"));
					array_push($values, $db->quote($userId));
				}

				$query
					->insert($db->quoteName($model->getTableName()))
					->columns($fields)
					->values(implode(',', $values));
			}
			$db->setQuery($query);
			$db->query();
		}
	}

	public function getNamedArray($header, $entry) {
		$result= array();
		$count = count($header);
		if ($count > 0)
		{
			for ($i=0; $i < $count; $i++)
			{
				$result[$header[$i]] = $entry[$i];
			}
		}
		return $result;
	}

	public function findRecordWithPrimaryFields($model, $row) {
                $db = JFactory::getDBO();
		$primaryKeys = $model->getImportPrimaryFields();
		$expressions = array();
		foreach (array_keys($primaryKeys) as $key) {
			$field = $primaryKeys[$key];
			array_push($expressions,$db->quoteName($field)."=".$db->quote($row[$key]));
		}
                $db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$where = implode(" AND ",$expressions);
		$query
			->select($db->quoteName($model->getIdFieldName()))
			->from($db->quoteName($model->getTableName()))
			->where($where);
		$db->setQuery($query);
		$results = $db->loadRowList();
		if ($results) {
			return $results[0][0];
		}
		return false;
	}

	public function resolveForeignKeys($model, $row) {
		$known_fields = $model->getFieldMapping();
		$foreign_keys = $model->getForeignKeys();
                $db = JFactory::getDBO();
		foreach (array_keys($foreign_keys) as $key)
		{
			$foreign_key = $foreign_keys[$key];
			$conditions = array();
			foreach ($foreign_key['remoteUniqueKey'] as $remote_field)
			{
				$column_name = array_search($key.".".$remote_field, $known_fields);
				if (empty($row[$column_name]))
				{
					array_push($conditions, "(".$db->quoteName($key.".".$remote_field)." IS NULL OR ".
						$db->quoteName($key.".".$remote_field)."='0000-00-00' OR ".
						$db->quoteName($key.".".$remote_field)."='')");
				}
				else
				{
					array_push($conditions, $db->quoteName($key.".".$remote_field)."=".$db->quote($row[$column_name]));
				}
				unset($row[$column_name]);
			}
			$query = $db->getQuery(true);
			$query->select($db->quoteName($key.".".$foreign_key['remoteKeyField']))
				->from($db->quoteName($foreign_key['remoteTable'],$key))
				->where(implode(" AND ",$conditions));
			$db->setQuery($query);
			$results = $db->loadRowList();
			if ($results)
			{
				$row[$foreign_key['localKeyField']] = $results[0][0];
			}
		}
		return $row;
	}
}
?>
