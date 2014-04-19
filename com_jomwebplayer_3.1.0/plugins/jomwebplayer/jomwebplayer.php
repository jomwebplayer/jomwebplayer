<?php

/*
 * @version		$Id: jomwebplayer.php 3.1.0 2012-10-28 $
 * @package		Joomla
 * @subpackage	jomwebplayer
 * @copyright   Copyright (C) 2012-2014 Jom Webplayer
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

class plgContentJomWebplayer extends JPlugin {

	function plgContentJomWebplayer( &$subject, $params ) {
		parent::__construct( $subject, $params );
	}

	function onContentPrepare($context, &$article, &$params, $page=0) {	
		$this->onPrepareContent( $article, $params, $page );
	}

	function onPrepareContent( &$row, &$params, $limitstart ) {
		// simple performance check to determine whether bot should process further
		if ( JString::strpos( $row->text, 'jomwebplayer' ) === false ) {
			return true;
		}
		
		// expression to search for
 		$regex = '/{jomwebplayer\s*.*?}/i';
		
		// find all instances of plugin and put in $matches
		preg_match_all( $regex, $row->text, $matches );

		// Number of plugins
 		$count = count( $matches[0] );
		
		$this->plgContentProcessPositions( $row, $matches, $count, $regex);
	}
	
	function plgContentProcessPositions ( $row, $matches, $count, $regex) {
 		for ( $i=0; $i < $count; $i++ )	{
 			$load  = str_replace( '{jomwebplayer', '', $matches[0][$i] );
 			$load  = str_replace( '}', '', $load );
			$load  = trim( $load );
			$load  = explode(" ",$load);
			$load  = implode("&",$load);
 			
			$modules	= $this->plgContentLoadPosition($load);
			$row->text 	= str_replace($matches[0][$i], $modules, $row->text );
 		}

  		// removes tags without matching module positions
		$row->text = preg_replace( $regex, '', $row->text );
	}
	
	function castAsArray($datas) {
	    $element = array();
		for ($i=0, $n=count($datas); $i < $n; $i++) {
			$row = $datas[$i];
		    $row = explode("=",$row );
            $element[$row[0]] = $row[1];
		}
		return $element;
	}

	function googleadsense() {
         $db = JFactory::getDBO();
         $query = "SELECT * FROM #__jomwebplayer_googleads";
         $db->setQuery( $query );
         $output = $db->loadObjectList();
		 
         return($output[0]);
	}
	
	function plgContentLoadPosition($load) {		
	    $width = $height = $video = $type = $category = $htmlNode = $ext = $contents = '';
	    parse_str($load);
		$width      = ($width    == '') ? 640 : $width;
		$height     = ($height   == '') ? 360 : $height;  
		$category   = ($category == '') ? ''  :str_replace(',', '%2C', $category);
		$flashvars  = 'baseJ='.JURI::root().'&';
		$load       = str_replace(',', '%2C', $load);
		$load       = str_replace('autoplay', 'autoStart', $load);
		$flashvars .= $load;
		$flashvars .= JRequest::getCmd('wid') ? '&id='.JRequest::getCmd('wid')  : '' ;
		
		$googleads = $this->googleadsense();		
		if($googleads->plugin == 1 && $width >= 350 && $height >= 350) {
			$ad = 1;
		} else {
			$ad = 0;
		}
		require JPATH_ROOT.'/'.'components'.'/'.'com_jomwebplayer'.'/'.'models'.'/'.'embed.php';		
		
		return $contents;
	}

}
?>