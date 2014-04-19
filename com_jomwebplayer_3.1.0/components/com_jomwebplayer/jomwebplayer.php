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

JLoader::register('JomWebplayerController', JPATH_COMPONENT_ADMINISTRATOR.'/controllers/controller.php');
JLoader::register('JomWebplayerView', JPATH_COMPONENT_ADMINISTRATOR.'/views/view.php');
JLoader::register('JomWebplayerModel', JPATH_COMPONENT_ADMINISTRATOR.'/models/model.php');
JLoader::register('JomWebplayerUtility', JPATH_COMPONENT_ADMINISTRATOR.'/libs/utility.php');

// Define constants for all pages
if(!defined('DS')) { define('DS',DIRECTORY_SEPARATOR); }
define( 'COM_JOMWEBPLAYER_BASEURL', JURI::root().'index.php?option=com_jomwebplayer' );
define( 'UPLOAD_DIR', 'media'.DS.'com_jomwebplayer'.DS );
define( 'JOMWEBPLAYER_UPLOAD_BASE', JPATH_ROOT.DS.UPLOAD_DIR );
define( 'JOMWEBPLAYER_UPLOAD_BASEURL', JURI::root().str_replace( DS, '/', UPLOAD_DIR ) );
if (version_compare(JVERSION, '1.6.0', '<')) {
	define( 'JOMWEBPLAYER_JVERSION', '' );
} else {
	define( 'JOMWEBPLAYER_JVERSION', '3.0' );
}

// Require the base controller
require_once JPATH_COMPONENT.DS.'controller.php';

// Initialize the controller
$controller = new JomWebplayerControllerDefault( );

// Perform the Request task
if(JRequest::getCmd('view') == 'category' && !JRequest::getCmd('wid')){
	JRequest::setVar('view', 'categories');
} else if(JRequest::getCmd('view') == 'video' && !JRequest::getCmd('wid')){
	JRequest::setVar('view', 'videos');
}

$controller->execute(JRequest::getCmd('view'));
$controller->redirect();

?>