<?php

/*
 * @version		$Id: mod_jomwebplayerupload.php 3.1.0 2012-10-28 $
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
 
$userobj = JFactory::getUser();	
$user = $userobj->get('username');
if(!$user) {
	echo JText::_('You need to Register / Login to upload your Videos');
	return;
}

$items = modjomwebplayeruploadHelper::getItems( $params );

$category_options[] = JHTML::_('select.option', 'none', JText::_('Uncategorised'));
$categories = modjomwebplayeruploadHelper::getcategories();		 
foreach ( $categories as $item ) {
	$item->treename = JString::str_ireplace('&#160;', '-', $item->treename);
	$category_options[] = JHTML::_('select.option', $item->name, $item->treename );
}

if(JRequest::getCmd('add')) {
	require (JModuleHelper::getLayoutPath('mod_jomwebplayerupload', 'default_add'));
} else if($uid = JRequest::getCmd('uid')) {
	$data = modjomwebplayeruploadHelper::getrow($uid);
	require (JModuleHelper::getLayoutPath('mod_jomwebplayerupload', 'default_edit'));
} else {
	$data = modjomwebplayeruploadHelper::getvideos();
	require (JModuleHelper::getLayoutPath('mod_jomwebplayerupload', 'default_videos'));
}

?>