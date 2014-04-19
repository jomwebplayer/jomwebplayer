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

// Import Joomla! libraries
jimport( 'joomla.application.component.view');

class JomWebplayerViewGoogleads extends JomWebplayerView {

    function display($tpl = null) {
	    $model = $this->getModel();
		
        $data  = $model->getdata();
		$this->assignRef('data', $data);
		
		JSubMenuHelper::addEntry(JText::_('General Settings'), 'index.php?option=com_jomwebplayer&view=settings');
		JSubMenuHelper::addEntry(JText::_('Category'), 'index.php?option=com_jomwebplayer&view=category');
		JSubMenuHelper::addEntry(JText::_('Videos'), 'index.php?option=com_jomwebplayer&view=videos');		
		JSubMenuHelper::addEntry(JText::_('Google Adsense'), 'index.php?option=com_jomwebplayer&view=googleads', true);
		
		JToolBarHelper::title(JText::_('Jom Webplayer'), 'jomwebplayer');
        JToolBarHelper::save('save', 'Save');		
		
        parent::display($tpl);
    }
	
}

?>