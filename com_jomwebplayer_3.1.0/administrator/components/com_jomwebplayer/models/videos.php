<?php

/*
 * @version		$Id: videos.php 3.1.0 2012-10-28 $
 * @package		Joomla
 * @subpackage	jomwebplayer
 * @copyright   Copyright (C) 2012-2014 Jom Webplayer
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
jimport('joomla.application.component.model');

class JomWebplayerModelVideos extends JomWebplayerModel {

    function __construct() {
		parent::__construct();
    }
	
	function getvideos() {
         $mainframe        = JFactory::getApplication();	
		 $option           = JRequest::getCmd('option');
		 $view             = JRequest::getCmd('view');
		 
		 $limit            = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		 $limitstart       = $mainframe->getUserStateFromRequest($option.$view.'.limitstart', 'limitstart', 0, 'int');
		 $limitstart       = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);		 
		 $filter_category  = $mainframe->getUserStateFromRequest($option.$view.'filter_category', 'filter_category', '', 'string');
		 $filter_state     = $mainframe->getUserStateFromRequest($option.$view.'filter_state', 'filter_state', -1, 'int');
		 $search           = $mainframe->getUserStateFromRequest($option.$view.'search', 'search', '', 'string');
		 $search           = JString::strtolower($search);
     
    	 $db               = JFactory::getDBO();
		 $query            = "SELECT * FROM #__jomwebplayer_videos";

		 $where            = array();
		 
		 if ($filter_state > - 1) {
			$where[]       = "published={$filter_state}";
		 }
		
		 if ( $search ) {
		 	$escaped       = (JOMWEBPLAYER_JVERSION == '3.0') ? $db->escape( $search, true ) : $db->getEscaped( $search, true );
			$where[]       = 'LOWER(title) LIKE '.$db->Quote( '%'.$escaped.'%', false );
		 }
		 
		 if ($filter_category != '') {
			$where[]       = 'category='.$db->Quote($filter_category);
		 }
		 
		 $where 		   = ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );
		 
		 $query           .= $where;
		 $query           .= " ORDER BY category,ordering";
    	 $db->setQuery ( $query, $limitstart, $limit);
    	 $output           = $db->loadObjectList();
         return($output);
	}
	
	function gettotal() {
         $mainframe        = JFactory::getApplication();	
		 $option           = JRequest::getCmd('option');
		 $view             = JRequest::getCmd('view');
		 
		 $filter_category  = $mainframe->getUserStateFromRequest($option.$view.'filter_category', 'filter_category', '', 'string');
		 $filter_state     = $mainframe->getUserStateFromRequest($option.$view.'filter_state', 'filter_state', -1, 'int');
		 $search           = $mainframe->getUserStateFromRequest($option.$view.'search', 'search', '', 'string');
		 $search           = JString::strtolower($search);
     
    	 $db               = JFactory::getDBO();
		 $query            = "SELECT COUNT(*) FROM #__jomwebplayer_videos";

		 $where            = array();
		 
		 if ($filter_state > - 1) {
			$where[]       = "published={$filter_state}";
		 }
		
		 if ( $search ) {
		 	$escaped       = (JOMWEBPLAYER_JVERSION == '3.0') ? $db->escape( $search, true ) : $db->getEscaped( $search, true );
			$where[]       = 'LOWER(title) LIKE '.$db->Quote( '%'.$escaped.'%', false );
		 }
		 
		 if ($filter_category != '') {
			$where[]       = 'category='.$db->Quote($filter_category);
		 }
		 
		 $where 		   = ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );
		 
		 $query           .= $where;
    	 $db->setQuery ( $query );
    	 $output           = $db->loadResult();
         return($output);
	}
	
	function getpagination() {
		 $mainframe  = JFactory::getApplication();	
		 $option     = JRequest::getCmd('option');
		 $view       = JRequest::getCmd('view');
		 
		 $total      = $this->gettotal();
		 $limit      = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		 $limitstart = $mainframe->getUserStateFromRequest($option.$view.'.limitstart', 'limitstart', 0, 'int');
		 $limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);
     
    	 jimport( 'joomla.html.pagination' );
		 $pageNav    = new JPagination($total, $limitstart, $limit);
         return($pageNav);
	}
	
	function getlists() {
		 $mainframe              = JFactory::getApplication();	
		 $option                 = JRequest::getCmd('option');
		 $view                   = JRequest::getCmd('view');
		 
		 $filter_category        = $mainframe->getUserStateFromRequest($option.$view.'filter_category', 'filter_category','', 'string');
		 $filter_state           = $mainframe->getUserStateFromRequest( $option.$view.'filter_state','filter_state',-1,'int' );
		 $search                 = $mainframe->getUserStateFromRequest($option.$view.'search','search','','string');
		 $search                 = JString::strtolower ( $search );
     
    	 $lists                  = array ();
		 $lists ['search']       = $search;	
            
		 $filter_state_options[] = JHTML::_('select.option', -1, JText::_('- Select Publishing State -'));
		 $filter_state_options[] = JHTML::_('select.option', 1, JText::_('Published'));
		 $filter_state_options[] = JHTML::_('select.option', 0, JText::_('Unpublished'));
		 $lists['state']         = JHTML::_('select.genericlist', $filter_state_options, 'filter_state', 'onchange="this.form.submit();"', 'value', 'text', $filter_state);
		 
		 $category_options[]     = JHTML::_('select.option', '', JText::_('- Select By Category -'));
		 $category_options[]     = JHTML::_('select.option', 'none', JText::_('- Uncategorised -'));
		 $categories             = $this->getcategories();		 
		 foreach ( $categories as $item ) {
			$item->treename      = JString::str_ireplace('&#160;', '-', $item->treename);
			$category_options[]  = JHTML::_('select.option', $item->name, $item->treename );
		 }
		 $lists['categories']    = JHTML::_('select.genericlist', $category_options, 'filter_category', 'onchange="this.form.submit();"', 'value', 'text', $filter_category);
		 
         return($lists);
	}
	
	function getcategories() {
         $db = JFactory::getDBO();
		 $query = 'SELECT * FROM #__jomwebplayer_category';
		 $db->setQuery( $query );
		 $mitems = $db->loadObjectList();
		
		 $children = array();
		 if ( $mitems ) {
			foreach ( $mitems as $v )
			{
				$v->title = $v->name;
				$v->parent_id = $v->parent;
				$pt = $v->parent;				
				$list = @$children[$pt] ? $children[$pt] : array();
				array_push( $list, $v );
				$children[$pt] = $list;
			}
		 }
		
		 $list = JHTML::_('menu.treerecurse', 0, '', array(), $children, 9999, 0, 0 );		
		 return $list;
	}
	
	function getapproval() {
         $db     = JFactory::getDBO();
         $query  = "SELECT COUNT(*) FROM #__jomwebplayer_videos WHERE published=0 AND user!='Admin'";
         $db->setQuery( $query );
         $output = $db->loadResult();
         return($output);
	}
	
	function getexe() {
         $db     = JFactory::getDBO();
         $query  = "SELECT ffmpeg, flvtool2, qtfaststart FROM #__jomwebplayer_settings";
         $db->setQuery( $query );
         $output = $db->loadObjectList();
         return($output);
	}
	
	function getrow() {
         $db  = JFactory::getDBO();
         $row = JTable::getInstance('jomwebplayervideos', 'Table');
         $cid = JRequest::getVar( 'cid', array(0), '', 'array' );
         $id  = $cid[0];
         $row->load($id);
         $lists['published'] = JHTML::_('select.booleanlist','published',$row->published);

         return $row;
	}
	
	function save() {
	  $mainframe = JFactory::getApplication();	  
	  $row       = JTable::getInstance('jomwebplayervideos', 'Table');
	  $cid       = JRequest::getVar( 'cid', array(0), '', 'array' );
      $id        = $cid[0];
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
  
  	  if(!$row->thumb && !JRequest::getVar('uploadthumb')) {
		$row->thumb = 'http://img.youtube.com/vi/default.jpg';
	  }
	  
	  $row->reorder( "category='" . $row->category . "'" );
	  
	  if(!$row->store()) {
		JError::raiseError(500, $row->getError() );
	  }
	 
	  $task = JRequest::getCmd('task');	  
	  switch ($task) {
        case 'apply':
             $msg  = 'Changes Saved';
             $link = 'index.php?option=com_jomwebplayer&view=videos&task=edit&'. JomWebplayerUtility::getToken() .'=1&'.'cid[]='.$row->id;
             break;
        case 'savevideos':
        default:
              $msg  = 'Saved';
              $link = 'index.php?option=com_jomwebplayer&view=videos';
              break;
        }

	  $mainframe->redirect($link, $msg);	  
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
	
	function RemoveExtension($strName) {  
     	$ext = strrchr($strName, '.');  

     	if($ext !== false) {  
         	$strName = substr($strName, 0, -strlen($ext));  
     	}
		
     	return $strName;  
	} 

	function delete() {
	    $mainframe = JFactory::getApplication();
        $cid       = JRequest::getVar( 'cid', array(), '', 'array' );
        $db        = JFactory::getDBO();
        $cids      = implode( ',', $cid );
        if(count($cid)) {
            $query = "DELETE FROM #__jomwebplayer_videos WHERE id IN ( $cids )";
            $db->setQuery( $query );
            if (!$db->query()) {
                echo "<script> alert('".$db->getErrorMsg()."');window.history.go(-1); </script>\n";
            }
        }

        $mainframe->redirect( 'index.php?option=com_jomwebplayer&view=videos' );
	}
	
	function cancel() {
	  $mainframe = JFactory::getApplication();
	  $link      = 'index.php?option=com_jomwebplayer&view=videos';
	  $mainframe->redirect($link);
	}
	
	function saveorder() {
		$mainframe  = JFactory::getApplication();

		$db	        = JFactory::getDBO();
		$cid        = JRequest::getVar( 'cid', array(0), '', 'array' );
		$total      = count( $cid );
		$order      = JRequest::getVar( 'order', array(0), '', 'array' );
		JArrayHelper::toInteger($order, array(0));
		 
		$row        = JTable::getInstance('jomwebplayervideos', 'Table');
		$groupings  = array();
		for( $i=0; $i < $total; $i++ ) {
			$row->load( (int) $cid[$i] );
			$groupings[] = $row->category;
 			if ($row->ordering != $order[$i]) {
				$row->ordering  = $order[$i];
				if (!$row->store()) {
					JError::raiseError(500, $db->getErrorMsg() );
				}
			}
		}
 
		$groupings = array_unique($groupings);
		foreach ($groupings as $group) {
			$row->reorder('category = "'.$group.'"');
		}
 
		$mainframe->redirect('index.php?option=com_jomwebplayer&view=videos', 'New ordering saved');
	}
	
	function move($direction) {
		$mainframe  = JFactory::getApplication();
		$cid        = JRequest::getVar( 'cid', array(0), '', 'array' );
		$row        =  JTable::getInstance('jomwebplayervideos', 'Table');
		$row->load($cid[0]);
		$row->move($direction, 'category = "'.$row->category.'"');
		$row->reorder('category = "'.$row->category.'"');
	  	$mainframe->redirect('index.php?option=com_jomwebplayer&view=videos', 'New ordering saved');		
	}
	
	function publish() {
		$mainframe = JFactory::getApplication();
		$cid       = JRequest::getVar( 'cid', array(), '', 'array' );
        $publish   = ( JRequest::getCmd('task') == 'publish' ) ? 1 : 0;
			
        $reviewTable = JTable::getInstance('jomwebplayervideos', 'Table');
        $reviewTable->publish($cid, $publish);
        $mainframe->redirect( 'index.php?option=com_jomwebplayer&view=videos' );	        
    }

}

?>