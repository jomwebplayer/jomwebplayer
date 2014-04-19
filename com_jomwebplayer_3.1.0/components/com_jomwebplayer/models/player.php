<?php

/*
 * @version		$Id: player.php 3.1.0 2012-10-28 $
 * @package		Joomla
 * @subpackage	jomwebplayer
 * @copyright   Copyright (C) 2012-2014 Jom Webplayer
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class JomWebplayerModelPlayer extends JomWebplayerModel {

	function __construct() {
		parent::__construct();
    }
	
	function getplayer()
    {
        $player = JPATH_COMPONENT.DS.'player.swf';
		
		ob_clean();
		header("content-type:application/x-shockwave-flash");
		readfile($player);
		exit();
	}
}

?>