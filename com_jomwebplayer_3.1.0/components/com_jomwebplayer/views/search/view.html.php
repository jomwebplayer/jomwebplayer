<?php

/*
 * @version		$Id: view.html.php 3.1.0 2012-10-28 $
 * @package		Joomla
 * @subpackage	jomwebplayer
 * @copyright   Copyright (C) 2012-2014 Jom Webplayer
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access 
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.view');

class JomWebplayerViewSearch extends JomWebplayerView {

	function display($tpl = null) {
		$model 	= $this->getModel();
		
		$settings = $model->getsettings();
        $this->assignRef('settings', $settings);
		
        $search = $model->getsearch();
        $this->assignRef('search', $search);
				
        parent::display($tpl);
    }
	
}

?>