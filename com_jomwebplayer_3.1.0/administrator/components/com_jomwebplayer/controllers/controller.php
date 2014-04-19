<?php

/*
 * @version		$Id: controller.php 3.1.0 2012-10-28 $
 * @package		Joomla
 * @subpackage	jomwebplayer
 * @copyright   Copyright (C) 2012-2014 Jom Webplayer
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

if (version_compare(JVERSION, '3.0', 'ge')) {

    class JomWebplayerController extends JControllerLegacy {
	
        public function display($cachable = false, $urlparams = array()) {
            parent::display($cachable, $urlparams);
        }
		
    }

} else if (version_compare(JVERSION, '2.5', 'ge')) {

    class JomWebplayerController extends JController {
	
        public function display($cachable = false, $urlparams = false) {
            parent::display($cachable, $urlparams);
        }

    }

} else {

    class JomWebplayerController extends JController {
	
        public function display($cachable = false) {
            parent::display($cachable);
        }

    }

}

?>