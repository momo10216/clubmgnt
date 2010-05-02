<?php
/**
* @version		0.92
* @package		Joomla
* @subpackage	ClubManagement-Membership
* @copyright	Copyright (c) 2009 Norbert Kümin. All rights reserved.
* @license		http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author		Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

defined('_JEXEC') or die('Restricted access'); // no direct access

if ($this->params_menu->get("allow_edit") == "0")
{
	// Not allowed to edit
	nokCM_error(JText::_( 'ERROR_PERSON_EDIT_NOT_ALLOWED'), true); 
	return;
}

function show_list ($curobj)
{
	// Init
	$uri = JFactory::getURI();

	// Get columns
	$cols = array();
	$cols[] = $curobj->cmobject->getSetting("Primary_Key");
	for ($i=1;$i<=5;$i++)
	{
		$field = "column_".$i;
		$cols[] = $curobj->params_menu->get( $field );
	}

	// Calc sort
	if (count($cols)>0)
	{
		$sort="";
		for ($i=1;$i<=5;$i++)
		{
			if ($cols[$i]) $sort .= ",`".$cols[$i]."`";
		}
		if (strlen($sort) > 0) $sort = substr($sort,1);
	}

	// Calc where
	$user =& JFactory::getUser();
	$where = "`user_id`='".$user->id."'";

	$data = $curobj->cmobject->getViewData($cols,$where,$sort);

	//start output
	if ($this->data)
	{
		echo "<p align=\"center\">\n";
		foreach($data as $row)
		{
			//Calc url
			$uri->setVar("id",$row[0]);
			$url = $uri->toString();
			echo "<a href=\"".$url."\">";
			$text="";
			for ($i=1;$i<=5;$i++)
			{
				if ($row[$i]) $text .= " ".$row[$i];
			}
			echo trim($text);
			echo "</a><br/>\n";
		}
		echo "</p>\n";
	}
}

function no_record ()
{
	nokCM_error(JText::_( 'ERROR_PERSON_EDIT_NO_RECORD'), true); 
}

function do_edit ($curobj, $id)
{
	// Get columns
	$confcols = $curobj->params_menu->get( "allow_columns" );
	$cols = array();
	$column_edit = $curobj->cmobject->column_edit;
	foreach($confcols as $confcol)
	{
		$cols[$confcol] = $column_edit[$confcol];
	}
	$uri = JFactory::getURI();
	$curobj->cmobject->edit($id,$cols,$uri->toString());
?>
<p align="center">
	<button type="button" onclick="submitbutton('save')">
		<?php echo JText::_('Save') ?>
	</button>
	<button type="button" onclick="submitbutton('cancel')">
		<?php echo JText::_('Cancel') ?>
	</button>
</p>
<?php
}

function do_save ($curobj)
{
	// Get columns
	$confcols = $curobj->params_menu->get( "allow_columns" );
	$cols = array();
	$column_edit = $curobj->cmobject->column_edit;
	foreach($confcols as $confcol)
	{
		$cols[$confcol] = $column_edit[$confcol];
	}
	$savecols = $cols;
	$savecols["modifiedby"] = $column_edit["modifiedby"];
	$savecols["modifieddate"] = $column_edit["modifieddate"];
	$id = JRequest::getVar("id");
	$curobj->cmobject->save($id,$savecols);
	$curobj->cmobject->showdetail($id,$cols);
}

global $mainframe;
$task = JRequest::getVar("task");
switch ($task)
{
	case "save":
		do_save($this);
		break;
	case "cancel":
		$mainframe->redirect("index.php",JText::_("Data not saved"));
		break;
	case "edit":
	default:
		$uri = JFactory::getURI();
		$id = $uri->getVar('id');
		if (!$id) $id = JRequest::getVar("id");
		//Count records
		if (!$id)
		{
			$id_list = $this->cmobject->user_record_ids();
		}
		else
		{
			$id_list = $this->cmobject->user_record_ids($id);
		}
		if (count($id_list) < 1) no_record();
		if (count($id_list) == 1) do_edit($this, $id_list[0][0]);
		if (count($id_list) > 1) show_list($this);
		break;
}
?>
