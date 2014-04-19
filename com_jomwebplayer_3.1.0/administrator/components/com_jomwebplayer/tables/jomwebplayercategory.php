<?php

/*
 * @version		$Id: jomwebplayercategory.php 3.1.0 2012-10-28 $
 * @package		Joomla
 * @subpackage	jomwebplayer
 * @copyright   Copyright (C) 2012-2014 Jom Webplayer
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// Include library dependencies
jimport('joomla.filter.input');

class TableJomWebplayerCategory extends JTable {

	var $id              = null;
	var $name            = null;
	var $parent          = null;
	var $ordering        = null;
	var $type            = null;
	var $image           = null;
	var $metakeywords    = null;
	var $metadescription = null;
	var $published       = 0;

	function __construct(& $db) {
		parent::__construct('#__jomwebplayer_category', 'id', $db);
	}

	function check() {
		return true;
	}
	
}

?>