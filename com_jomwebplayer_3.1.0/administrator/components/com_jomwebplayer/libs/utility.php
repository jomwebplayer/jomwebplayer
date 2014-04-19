<?php

/*
 * @version		$Id: utility.php 3.1.0 2012-10-28 $
 * @package		Joomla
 * @subpackage	jomwebplayer
 * @copyright   Copyright (C) 2012-2014 Jom Webplayer
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

class JomWebplayerUtility {

	public static function getToken() {
	
		if (version_compare(JVERSION, '1.6.0', '<')) {
			return JUtility::getToken();
		} else {
			return JSession::getFormToken();
		}
		
	}

}

?>