<?php

/*
 * @version		$Id: mod_jomwebplayergallery.php 3.1.0 2012-10-28 $
 * @package		Joomla
 * @subpackage	jomwebplayer
 * @copyright   Copyright (C) 2012-2014 Jom Webplayer
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
 
if(!defined('DS')) { 
	define('DS',DIRECTORY_SEPARATOR); 
}
 
// Include the syndicate functions only once
require_once( dirname(__FILE__).DS.'helper.php' );
 
$catid      = modjomwebplayergalleryHelper::getCategory();
$items      = modjomwebplayergalleryHelper::getItems( $params, $catid );
$pagination = modjomwebplayergalleryHelper::getPagination( $params, $catid );
$googleads  = modjomwebplayergalleryHelper::googleads();

if($items['type'] == 'Category' && !JRequest::getCmd('catid')) {
	require (JModuleHelper::getLayoutPath('mod_jomwebplayergallery', 'default_categories'));	
} else {
	require (JModuleHelper::getLayoutPath('mod_jomwebplayergallery', 'default_videos'));	
}

?>