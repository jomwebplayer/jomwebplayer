<?php

/*
 * @version		$Id: jomwebplayersettings.php 3.1.0 2012-10-28 $
 * @package		Joomla
 * @subpackage	jomwebplayer
 * @copyright   Copyright (C) 2012-2014 Jom Webplayer
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// Include library dependencies
jimport('joomla.filter.input');

class TableJomWebplayerSettings extends JTable {

	var $id               = null;
	var $width            = null;
    var $height           = null;
	var $title            = 0;
	var $description      = 0;
    var $licensekey       = null;
    var $logo             = null;
    var $logoposition     = null;
    var $logoalpha        = null;
    var $logotarget       = null;
    var $skinmode         = null;
    var $stretchtype      = null;
    var $buffertime       = null;
    var $volumelevel      = null;
    var $autoplay         = 0;
    var $playlistautoplay = 0;
	var $playlistopen     = 0;
	var $playlistrandom   = 0;
	var $ffmpeg           = null;
    var $flvtool2         = null;
	var $qtfaststart      = null;
	var $rows             = null;
	var $cols             = null;
	var $thumbwidth       = null;
	var $thumbheight      = null;
	var $subcategories    = null;
	var $relatedvideos    = null;	

	function __construct(& $db) {
		parent::__construct('#__jomwebplayer_settings', 'id', $db);
	}

	function check() {
		return true;
	}

}

?>