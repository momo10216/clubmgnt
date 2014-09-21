#!/bin/sh
# @version	$Id$
# @package	Joomla
# @subpackage	ClubManagement-Tools
# @copyright	Copyright (c) 2014 Norbert Kümin. All rights reserved.
# @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
# @author	Norbert Kuemin
# @authorEmail	momo_102@bluemail.ch

TMP_IMPL="`tempfile`"
TMP_LANG="`tempfile`"
find ../ -name \* ! -name \*~ ! -path \*language\* ! -path \*tols\* -exec grep "COM_CLUBMANAGEMENT" {} \; 2>/dev/null | sed 's/COM_CLUBMANAGEMENT\([0-Z_]*\)/\nCOM_CLUBMANAGEMENT\1\n/g' | grep "COM_CLUBMANAGEMENT" | sort | uniq > $TMP_IMPL
LANG_FILES="../language/en-GB.com_clubmanagement.ini"
for file in ${LANG_FILES}
do
	cat $file | sed '/^;/d' | grep "=" | sed 's/\=\"[^\"]*\"//g' | sed 's/\r//g' | sort > $TMP_LANG
	missingTokens="`comm -23 $TMP_IMPL $TMP_LANG`"
	for token in ${missingTokens}
	do
		echo "$token not found in $file"
	done
	missingTokens="`comm -13 $TMP_IMPL $TMP_LANG`"
	for token in ${missingTokens}
	do
		echo "$token orphaned"
	done
	rm "$TMP_LANG"
done
rm "$TMP_IMPL"

