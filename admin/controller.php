<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Main
* @copyright	Copyright (c) 2014 Norbert Kuemin. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
 
/**
 * General Controller of ClubManagement component
 */
class ClubManagementController extends JControllerLegacy
{
	/**
	 * @var		string	The default view.
	 * @since   1.6
	 */
	protected $default_view = 'persons';

        /**
         * display task
         *
         * @return void
         */

        function display($cachable = false, $urlparams = false)
        {
                // set default view if not set
                $input = JFactory::getApplication()->input;
                $view = JFactory::getApplication()->input->get('view', 'persons');
                if (($view != 'person') && ($view != 'person') &&
                    ($view != 'boardentry') && ($view != 'boardentries') &&
                    ($view != 'membership') && ($view != 'memberships') &&
                    ($view != '')) {
                    $input->set('view', 'persons');
                }

                // call parent behavior
                parent::display($cachable, $urlparams);
                return $this;
        }
}
?>
