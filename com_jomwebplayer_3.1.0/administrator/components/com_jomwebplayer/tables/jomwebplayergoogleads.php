<?php

/*
 * @version		$Id: jomwebplayergoogleads.php 3.1.0 2012-10-28 $
 * @package		Joomla
 * @subpackage	jomwebplayer
 * @copyright   Copyright (C) 2012-2014 Jom Webplayer
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// Include library dependencies
jimport('joomla.filter.input');

class TableJomWebplayerGoogleads extends JTable {

	var $id        = null;
	var $adscript  = null;
	var $component = 0;
	var $module    = 0;
	var $plugin    = 0;
	
	function __construct(& $db) {
		parent::__construct('#__jomwebplayer_googleads', 'id', $db);
	}

	function check() {
		return true;
	}
	
}

?>