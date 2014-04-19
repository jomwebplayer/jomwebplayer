<?php

/*
 * @version		$Id: user.php 3.1.0 2012-10-28 $
 * @package		Joomla
 * @subpackage	jomwebplayer
 * @copyright   Copyright (C) 2012-2014 Jom Webplayer
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class JomWebplayerModelUser extends JomWebplayerModel {

	function __construct() {
		parent::__construct();
    }
	
	function save()	{
	  $mainframe =  JFactory::getApplication();	
	  $session   = JFactory::getSession();
	  $user      = JFactory::getUser();  
	  $row       = JTable::getInstance('jomwebplayervideos', 'Table');
	  $cid       =  JRequest::getVar( 'cid', array(0), '', 'array' );
      $id        =  $cid[0];
      $row->load($id);
	  
      if(!$row->bind(JRequest::get('post'))) {
		JError::raiseError(500, $row->getError() );
	  }
	  
	  $row->description = JRequest::getVar('description', '', 'post', 'string', JREQUEST_ALLOWRAW);
	
	  if($row->type == 'General Upload') {
	  	jimport('joomla.filesystem.folder');
	    jimport('joomla.filesystem.file');
		
		if(!JFolder::exists(JOMWEBPLAYER_UPLOAD_BASE)) {
			JFolder::create(JOMWEBPLAYER_UPLOAD_BASE);
		}
		
	  	$row->video   = $this->general_upload('uploadvideo');
		$row->hdvideo = $this->general_upload('uploadhdvideo');
	  	$row->preview = $this->general_upload('uploadpreview');
	  	$row->thumb   = $this->general_upload('uploadthumb');
	  }
	  
	  if($row->type == 'FFMPEG Upload') {
	    jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.file');
		
		if(!JFolder::exists(JOMWEBPLAYER_UPLOAD_BASE)) {
			JFolder::create(JOMWEBPLAYER_UPLOAD_BASE);
		}
		
		$ffmpeg       = $this->ffmpeg_upload('uploadvideo');
		$row->video   = $ffmpeg['video'];
	  	$row->preview = $ffmpeg['preview'];
	  	$row->thumb   = $ffmpeg['thumb'];
	  }
	  
	  if($row->type == 'Youtube Videos') {
	     parse_str( parse_url( $row->video, PHP_URL_QUERY ), $youtubeID );
		 $row->video   = 'http://www.youtube.com/watch?v=' . $youtubeID['v'];
         $row->thumb   = 'http://img.youtube.com/vi/'.$youtubeID['v'].'/default.jpg';
		 $row->preview = 'http://img.youtube.com/vi/'.$youtubeID['v'].'/0.jpg';
	  }
	  
	  $row->user = (string) $user->get('username');
  
  	  if(!$row->thumb && !JRequest::getVar('uploadthumb')) {
		$row->thumb = 'http://img.youtube.com/vi/default.jpg';
	  }
	  
	  $row->reorder( "category='" . $row->category . "'" );
	  
	  if(!$row->store()){
		JError::raiseError(500, $row->getError() );
	  }
	 
	  $task = JRequest::getCmd('task');	  
	  $mainframe->redirect( $session->get('target') );	  
	}
	
	function general_upload($filename) {
	  $file = @JFile::makeSafe($_FILES[$filename]['name']);
	  $temp = @$_FILES[$filename]['tmp_name'];
	  
      if($file != "") {
     	 if(JFile::upload($temp, JOMWEBPLAYER_UPLOAD_BASE.$file)) {
		 	return JOMWEBPLAYER_UPLOAD_BASEURL.$file;
		 } else {
		 	JError::raiseWarning(21, 'Error Occured While Uploading!');
			return false;
		 }
	  }	
		
	}
	
	function ffmpeg_upload($filename) {
	  $dat           = array();
	  $file          = @JFile::makeSafe($_FILES[$filename]['name']);
	  $ext           = end(explode(".", $file));	  
	  $temp          = @$_FILES[$filename]['tmp_name'];
	  
	  $inputFile     = JOMWEBPLAYER_UPLOAD_BASE.$file;
      $content       = $this->RemoveExtension($file);
	  $outputFile    = JOMWEBPLAYER_UPLOAD_BASE.$content.'.flv';
	  $outputThumb   = JOMWEBPLAYER_UPLOAD_BASE.$content.'_thumb.jpg';
	  $outputPreview = JOMWEBPLAYER_UPLOAD_BASE.$content.'_preview.jpg';	  
	  $qtFile        = JOMWEBPLAYER_UPLOAD_BASE.$content.'_qt.mp4';
	  $outputHdFile  = JOMWEBPLAYER_UPLOAD_BASE.$content.'.mp4';

	  $exe           = $this->getexe();
	  $ffmpeg        = $exe[0]->ffmpeg;
	  $flvtool2      = $exe[0]->flvtool2;
	  $qtfaststart   = $exe[0]->qtfaststart;
	  
	  if(!file_exists(JOMWEBPLAYER_UPLOAD_BASE.$file)) {
     	 if ( JFile::upload($temp, JOMWEBPLAYER_UPLOAD_BASE.$file)) {
		   
		   	if($ext != '.flv') {
		   		$command  = $ffmpeg." -i ".$inputFile." -sameq -ar 44100 ".$outputFile;
           		exec($command);		   		
			}
			
			if($ext != '.mp4' && $qtfaststart != '') {
				$command  = $ffmpeg . " -i " . $inputFile . " -vcodec libx264 -acodec libfaac -sameq " . $qtFile;
           		exec($command);
				
				$command  = $qtfaststart . " "  . $qtFile .  " " . $outputHdFile;
           		exec($command);
				
				unlink($qtFile);		   		
			}

		   	$command      = $flvtool2 . " -U " . $outputFile;
           	exec($command);
			
			$command      = $ffmpeg." -ss 3 -i ".$outputFile." -f image2 -vframes 1 -s 114x74 ".$outputThumb;
           	exec($command);
			
			$command      = $ffmpeg." -ss 3 -i ".$outputFile." -f image2 -vframes 1 -s 320x240 ".$outputPreview;
           	exec($command);
			
			if(file_exists(JOMWEBPLAYER_UPLOAD_BASE.$content.'.flv')) {
				$dat['video']   = JOMWEBPLAYER_UPLOAD_BASEURL.$content.'.flv';
				$dat['thumb']   = JOMWEBPLAYER_UPLOAD_BASEURL.$content.'_thumb.jpg';
				$dat['preview'] = JOMWEBPLAYER_UPLOAD_BASEURL.$content.'_preview.jpg';
			}
			
			if(file_exists(JOMWEBPLAYER_UPLOAD_BASE.$content.'.mp4')) {
				$dat['hdvideo'] = JOMWEBPLAYER_UPLOAD_BASEURL.$content.'.mp4';				
			}
			
			return $dat;
				   
      	  } else {
		 	JError::raiseWarning(21, 'Error Occured While Uploading!');
			return false;
		  }		 
		}		
	}
	
	function getexe() {
         $db     = JFactory::getDBO();
         $query  = "SELECT ffmpeg, flvtool2, qtfaststart FROM #__jomwebplayer_settings";
         $db->setQuery( $query );
         $output = $db->loadObjectList();
         return($output);
	}
		
	function RemoveExtension($strName) {  
     	$ext = strrchr($strName, '.');  

     	if($ext !== false) {  
         	$strName = substr($strName, 0, -strlen($ext));  
     	}  
		
     	return $strName;  
	}
	
	function delete() {
	    $mainframe = JFactory::getApplication();
		$session   = JFactory::getSession();
		$uid       = JRequest::getCmd('uid');

        $db        = JFactory::getDBO();
        $query     = "DELETE FROM #__jomwebplayer_videos WHERE id=$uid";
        $db->setQuery( $query );
        $db->query();

        $mainframe->redirect( $session->get('target') );
	}
	 
	
}

?>