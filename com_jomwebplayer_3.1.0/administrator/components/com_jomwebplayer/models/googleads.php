<?php

/*
 * @version		$Id: googleads.php 3.1.0 2012-10-28 $
 * @package		Joomla
 * @subpackage	jomwebplayer
 * @copyright   Copyright (C) 2012-2014 Jom Webplayer
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
jimport('joomla.application.component.model');

// Import filesystem libraries.
jimport('joomla.filesystem.file');

class JomWebplayerModelGoogleads extends JomWebplayerModel {

    function __construct() {
		parent::__construct();
    }
	
	function getdata() {
         $db     = JFactory::getDBO();
         $query  = "SELECT * FROM #__jomwebplayer_googleads";
         $db->setQuery( $query );
         $output = $db->loadObjectList();
         return($output);
	}
	
	function save() {
	  $mainframe = JFactory::getApplication();
	  $row       = JTable::getInstance('jomwebplayergoogleads', 'Table');
	  $cid       = JRequest::getVar( 'cid', array(0), '', 'array' );
      $id        = $cid[0];
      $row->load($id);

      if(!$row->bind(JRequest::get('post',JREQUEST_ALLOWRAW))) {
		JError::raiseError(500, $row->getError() );
	  }
	
	  if(!$row->store()) {
		JError::raiseError(500, $row->getError() );
	  }

	  $msg  = 'Saved';
      $link = 'index.php?option=com_jomwebplayer&view=googleads';
	   
	  $mainframe->redirect($link, $msg);	  
	}
	
}

?>