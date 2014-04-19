<?php

/*
 * @version		$Id: html5.php 3.1.0 2012-10-28 $
 * @package		Joomla
 * @subpackage	jomwebplayer
 * @copyright   Copyright (C) 2012-2014 Jom Webplayer
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');
require_once JPATH_ROOT.'/'.'administrator'.'/'.'components'.'/'.'com_jomwebplayer'.'/'.'models'.'/'.'model.php';

class JomWebplayerModelHtml5 extends JomWebplayerModel {

	function __construct() {
		parent::__construct();
    }
	
	function getvideo($id, $category)
    {	
		 $db       = JFactory::getDBO();
		 $category = ($category != '') ? implode('","', explode('%2C', $category)) : '';
		 
		 if($id != '') {
		 	$query  = 'SELECT * FROM #__jomwebplayer_videos WHERE published = 1';
			$query .= ' AND id="'.$id.'"';
			$db->setQuery( $query );
			$output = $db->loadObjectList();
		 } else {
		 	$query  = 'SELECT * FROM #__jomwebplayer_videos WHERE published = 1';
		 	$query .= ($category != '') ? ' AND category IN ("'.$category.'")' : '';
		 	$query .= ' AND category NOT IN ( SELECT name FROM `#__jomwebplayer_category` WHERE published=0) ORDER BY category,ordering';
			$query .= ' LIMIT 1';		 
         	$db->setQuery( $query );
         	$output = $db->loadObjectList();
		 }
		 
		 if($output) {
    	 	jimport('joomla.filesystem.file');
    	 	$output[0]->ext = JFile::getExt($output[0]->video);
		 } else {
		 	$output = array();
			$output[0] = new stdClass;
		 	$output[0]->video = $output[0]->type = $output[0]->ext = $output[0]->streamer = '';
		 }
		 
		 return $output;
	}	
	
}

?>