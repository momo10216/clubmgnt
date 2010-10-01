<?php
/**
* @version		0.92
* @package		Joomla
* @subpackage	ClubManagement-Main
* @copyright	Copyright (c) 2009 Norbert Kümin. All rights reserved.
* @license		http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author		Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/
defined( '_JEXEC' ) or die( 'Restricted Access.' );

function com_install() {
	// Get database handle
	$database =& JFactory::getDBO();

	// Create tables version 0.1
	$database->setQuery("CREATE TABLE IF NOT EXISTS `#__nokCM_persons` (
`id` int(11) unsigned NOT NULL auto_increment,
`salutation`  varchar(25) NULL,
`firstname`  varchar(50) BINARY default '',
`middlename`  varchar(50) BINARY default '',
`name`  varchar(50) BINARY NOT NULL default '',
`nickname`  varchar(50) BINARY default '',
`birthday`  date default NULL,
`address`  varchar(100) BINARY default NULL,
`city`  varchar(50) BINARY default NULL,
`zip`  varchar(10) BINARY default NULL,
`country`  varchar(100) BINARY default NULL,
`state`  varchar(100) BINARY default NULL,
`telephone`  varchar(25) default NULL,
`mobile`  varchar(25) default NULL,
`url`  varchar(250) default NULL,
`email`  varchar(100) default NULL,
`user_id`  int(11) default NULL,
`description`  text default NULL,
`image`  varchar(250) default NULL,
`createdby`  varchar(50) default NULL,
`createddate`  datetime default NULL,
`modifiedby`  varchar(50) default NULL,
`modifieddate`  datetime default NULL,
PRIMARY KEY (`id`)
)");
	$database->query();
	$database->setQuery("CREATE TABLE IF NOT EXISTS `#__nokCM_memberships` (
`id` int(11) unsigned NOT NULL auto_increment,
`person_id`  int(11) NOT NULL default 0,
`type`  varchar(25) NOT NULL,
`begin`  date NOT NULL,
`end`  date default NULL,
`published`  int(1) default 0 NOT NULL,
`createdby`  varchar(50) default NULL,
`createddate`  datetime default NULL,
`modifiedby`  varchar(50) default NULL,
`modifieddate`  datetime default NULL,
PRIMARY KEY (`id`)
)");
	$database->query();
	$database->setQuery("CREATE TABLE IF NOT EXISTS `#__nokCM_board` (
`id` int(11) unsigned NOT NULL auto_increment,
`person_id`  int(11) NOT NULL default 0,
`job`  varchar(25) NOT NULL,
`begin`  date NOT NULL,
`end`  date default NULL,
`published`  int(1) default 0 NOT NULL,
`createdby`  varchar(50) default NULL,
`createddate`  datetime default NULL,
`modifiedby`  varchar(50) default NULL,
`modifieddate`  datetime default NULL,
PRIMARY KEY (`id`)
)");
	$database->query();
	$database->setQuery("CREATE TABLE IF NOT EXISTS `#__nokCM_report` (
`id` int(11) unsigned NOT NULL auto_increment,
`name`  varchar(50) NOT NULL,
`access` tinyint(11) unsigned NOT NULL default 0,
`sql`  text NOT NULL,
`columns`  varchar(255),
`createdby`  varchar(50) default NULL,
`createddate`  datetime default NULL,
`modifiedby`  varchar(50) default NULL,
`modifieddate`  datetime default NULL,
PRIMARY KEY (`id`)
)");
	$database->query();
	//$database->setQuery("DELETE #__nokCM_report` WHERE name='???'";
	//$database->query();
	//$database->setQuery("INSERT INTO #__nokCM_report` (name,sql,coulmns) VALUES ()";
	//$database->query();

	// Upgrade #__nokCM_persons (add columns)
	$database->setQuery( "Describe #__nokCM_persons" );
	$rows = $database->loadResultArray();
	$field_defs = array (
		'custom1' => 'varchar(255) default NULL',
		'custom2' => 'varchar(255) default NULL',
		'custom3' => 'varchar(255) default NULL',
		'custom4' => 'varchar(255) default NULL',
		'custom5' => 'varchar(255) default NULL',
		'birthname' => 'varchar(50) default NULL',
		'deceased' => 'date default NULL',
		'hh_person_id' => 'int(11) unsigned default NULL',
		'hh_salutation_override' => 'varchar(50) default NULL',
		'hh_name_override' => 'varchar(255) default NULL',
		'_import_id' => 'int(11) unsigned default NULL'
	);
	reset($field_defs);
	while (list($field, $def) = each($field_defs)) {
		if (!in_array($field, $rows)) {
			$database->setQuery("ALTER TABLE #__nokCM_persons ADD COLUMN `".$field."` ".$def);
			if ($database->query()) {
				echo "Added ".$field." DB field<br/>";
			}
		}
	}

	// Upgrade #__nokCM_board (add columns)
	$database->setQuery( "Describe #__nokCM_board" );
	$rows = $database->loadResultArray();
	$field_defs = array (
		'sortorder' => 'varchar(16) default NULL',
		'_import_id' => 'int(11) unsigned default NULL'
	);
	reset($field_defs);
	while (list($field, $def) = each($field_defs)) {
		if (!in_array($field, $rows)) {
			$database->setQuery("ALTER TABLE #__nokCM_board ADD COLUMN `".$field."` ".$def);
			if ($database->query()) {
				echo "Added ".$field." DB field<br/>";
			}
		}
	}

	// Upgrade #__nokCM_memberships (add columns)
	$database->setQuery( "Describe #__nokCM_memberships" );
	$rows = $database->loadResultArray();
	$field_defs = array (
		'_import_id' => 'int(11) unsigned default NULL'
	);
	reset($field_defs);
	while (list($field, $def) = each($field_defs)) {
		if (!in_array($field, $rows)) {
			$database->setQuery("ALTER TABLE #__nokCM_memberships ADD COLUMN `".$field."` ".$def);
			if ($database->query()) {
				echo "Added ".$field." DB field<br/>";
			}
		}
	}
	// Upgrade Template (modify column)
/*
	$database->setQuery("ALTER TABLE #__nokCM_persons MODIFY 'country' varchar(100) BINARY default NULL");
	$database->query();
*/

	// Upgrade Template (remove column)
/*
	$database->setQuery( "Describe #__nokCM_persons" );
	$rows = $database->loadResultArray();
	if (!in_array('email', $rows)) {
		$database->setQuery("ALTER TABLE #__nokCM_persons DROP 'email'");
		if ($database->query()) {
			echo 'Added email DB field!<br/>';
		}
	}
*/

    // Show installation result to user
	return '<h1>Installation successful!</h1>';
}
?>