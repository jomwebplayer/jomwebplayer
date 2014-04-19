<?php

/*
 * @version		$Id: mod_jomwebplayer.php 3.1.0 2012-10-28 $
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
 
$params->def('showtitle', 0);
$params->def('showdscription', 0);
$params->def('autodetect', 1);

$items = modjomwebplayerHelper::getItems( $params );
$googleads = modjomwebplayerHelper::googleads();

require(JModuleHelper::getLayoutPath('mod_jomwebplayer'));

?>