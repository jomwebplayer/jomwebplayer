<?php

/*
 * @version		$Id: jomwebplayerskin.php 3.1.0 2012-10-28 $
 * @package		Joomla
 * @subpackage	jomwebplayer
 * @copyright   Copyright (C) 2012-2014 Jom Webplayer
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// Include library dependencies
jimport('joomla.filter.input');

class TableJomWebplayerSkin extends JTable {

	var $id           = null;
    var $controlbar   = 0;
    var $playpause    = 0;
    var $progressbar  = 0;
    var $timer        = 0;
    var $share        = 0;
    var $volume       = 0;
    var $fullscreen   = 0;
    var $playdock     = 0;
    var $videogallery = 0;

	function __construct(& $db) {
		parent::__construct('#__jomwebplayer_skin', 'id', $db);
	}

	function check() {
		return true;
	}

}

?>