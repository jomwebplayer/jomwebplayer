<?php

/*
 * @version		$Id: views.php 3.1.0 2012-10-28 $
 * @package		Joomla
 * @subpackage	jomwebplayer
 * @copyright   Copyright (C) 2012-2014 Jom Webplayer
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class JomWebplayerModelViews extends JomWebplayerModel {

	function __construct() {
		parent::__construct();
    }
	
	function addview()
    {
		 ob_clean();
	     $id               = JRequest::getCmd('id');
         $mainframe        = JFactory::getApplication();	
     
    	 $db               = JFactory::getDBO();
		 $query            = "SELECT views FROM #__jomwebplayer_videos WHERE id=".$id;
    	 $db->setQuery ( $query );
    	 $output           = $db->loadObjectList();
		 
		 $count            = $output[0]->views + 1;
	 
		 $query            = "UPDATE #__jomwebplayer_videos SET views=".$count." WHERE id=".$id;
    	 $db->setQuery ( $query );
		 $db->query();
		 exit();
	}
	
}

?>