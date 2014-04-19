<?php

/*
 * @version		$Id: jomwebplayer.php 3.1.0 2012-10-28 $
 * @package		Joomla
 * @subpackage	jomwebplayer
 * @copyright   Copyright (C) 2012-2014 Jom Webplayer
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

JLoader::register('JomWebplayerController', JPATH_COMPONENT.'/controllers/controller.php');
JLoader::register('JomWebplayerView', JPATH_COMPONENT.'/views/view.php');
JLoader::register('JomWebplayerModel', JPATH_COMPONENT.'/models/model.php');
JLoader::register('JomWebplayerUtility', JPATH_COMPONENT.'/libs/utility.php');

// Define constants for all pages
if(!defined('DS')) { define('DS',DIRECTORY_SEPARATOR); }
define( 'UPLOAD_DIR', 'media'.DS.'com_jomwebplayer'.DS );
define( 'JOMWEBPLAYER_UPLOAD_BASE', JPATH_ROOT.DS.UPLOAD_DIR );
define( 'JOMWEBPLAYER_UPLOAD_BASEURL', JURI::root().str_replace( DS, '/', UPLOAD_DIR ) );
 
// CSS
$document = JFactory::getDocument();
if (version_compare(JVERSION, '3.0', 'ge')) {
	$document->addStyleSheet( JURI::base().'components/com_jomwebplayer/css/jomwebplayer.j3.css?r=' . rand() );
	define( 'JOMWEBPLAYER_JVERSION', '3.0' );
} else {
	$document->addStyleSheet( JURI::base().'components/com_jomwebplayer/css/jomwebplayer.css?r=' . rand() );
	define( 'JOMWEBPLAYER_JVERSION', '' );	
}

// Require the base controller
if(JRequest::getCmd('view') == '') {
	JRequest::setVar('view', 'settings');
}
$controller = JRequest::getCmd('view');
$controller = JString::strtolower( $controller );
require_once JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';

// Initialize the controller
$classname  = 'JomWebplayerController'.$controller;
$controller = new $classname();

// Perform the Request task
if(JRequest::getCmd('task') == '') {
	JRequest::setVar('task', JRequest::getCmd('view'));
}
$controller->execute( JRequest::getCmd('task') );
$controller->redirect();

?>