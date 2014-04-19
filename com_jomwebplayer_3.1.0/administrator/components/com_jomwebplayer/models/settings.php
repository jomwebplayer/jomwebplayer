<?php

/*
 * @version		$Id: settings.php 3.1.0 2012-10-28 $
 * @package		Joomla
 * @subpackage	jomwebplayer
 * @copyright   Copyright (C) 2012-2014 Jom Webplayer
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
jimport('joomla.application.component.model');

class JomWebplayerModelSettings extends JomWebplayerModel {

    function __construct() {
		parent::__construct();
    }
	
	function getsettings() {
         $db     = JFactory::getDBO();
         $query  = "SELECT * FROM #__jomwebplayer_settings";
         $db->setQuery( $query );
         $output = $db->loadObjectList();
         return($output[0]);
	}
	
	function getskin() {
         $db     = JFactory::getDBO();
         $query  = "SELECT * FROM #__jomwebplayer_skin";
         $db->setQuery( $query );
         $output = $db->loadObjectList();
         return($output);
	}
	
	function save() {
	  $row = JTable::getInstance('jomwebplayersettings', 'Table');
	  $cid = JRequest::getVar( 'cid', array(0), '', 'array' );
      $id  = $cid[0];
      $row->load($id);

      if(!$row->bind(JRequest::get('post'))) {
		JError::raiseError(500, $row->getError() );
	  }
	  
	  $row->logo = $this->upload('logo');
	
	  if(!$row->store()) {
		JError::raiseError(500, $row->getError() );
	  }  
	  
	  $this->saveskin();
	}
	
	function saveskin() {
	  $mainframe = JFactory::getApplication();
	  $row       = JTable::getInstance('jomwebplayerskin', 'Table');
	  $cid       = JRequest::getVar( 'cid', array(0), '', 'array' );
      $id        = $cid[0];
      $row->load($id);

      if(!$row->bind(JRequest::get('post'))) {
		JError::raiseError(500, $row->getError() );
	  }
	
	  if(!$row->store()) {
		JError::raiseError(500, $row->getError() );
	  }
	  
	  $msg  = 'Saved';
      $link = 'index.php?option=com_jomwebplayer&view=settings';

	  $mainframe->redirect($link, $msg);	  
	}
	
	function upload($filename) {	
	  jimport('joomla.filesystem.folder');
	  jimport('joomla.filesystem.file');
	  
	  if(!JFolder::exists(JOMWEBPLAYER_UPLOAD_BASE)) {
			JFolder::create(JOMWEBPLAYER_UPLOAD_BASE);
	  }
		
	  $file = JFile::makeSafe($_FILES[$filename]['name']);
	  $temp = $_FILES[$filename]['tmp_name'];
	  
      if($file != "") {
     	 if(JFile::upload($temp, JOMWEBPLAYER_UPLOAD_BASE.$file)) {
		 	return JOMWEBPLAYER_UPLOAD_BASEURL.$file;
		 } else {
		 	JError::raiseWarning(21, 'Error Occured While Uploading!');
			return false;
		 }
	  }	
	  	  
	}
	
}

?>