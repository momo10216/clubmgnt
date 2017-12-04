IF NOT EXISTS( SELECT NULL FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '#__nokCM_memberships' AND column_name = 'catid')  THEN
	ALTER TABLE `#__nokCM_memberships` ADD `catid` int(11) NOT NULL DEFAULT '0';
END IF;
IF NOT EXISTS( SELECT NULL FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '#__nokCM_board' AND column_name = 'catid')  THEN
	ALTER TABLE `#__nokCM_board` ADD `catid` int(11) NOT NULL DEFAULT '0';
END IF;

