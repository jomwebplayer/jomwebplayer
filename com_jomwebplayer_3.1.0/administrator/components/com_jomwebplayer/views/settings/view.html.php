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

class JomWebplayerViewSettings extends JomWebplayerView {

    function display($tpl = null) {
	    $model = $this->getModel();
		
        $settings  = $model->getsettings();
		$this->assignRef('settings', $settings);
		
		$skin  = $model->getskin();
		$this->assignRef('skin', $skin);
		
		$title = $this->buildSelectBox('title', $settings->title);
		$this->assignRef('title', $title);
		
		$description = $this->buildSelectBox('description', $settings->description);
		$this->assignRef('description', $description);
		
		$subcategories = $this->buildSelectBox('subcategories', $settings->subcategories);
		$this->assignRef('subcategories', $subcategories);
		
		$relatedvideos = $this->buildSelectBox('relatedvideos', $settings->relatedvideos);
		$this->assignRef('relatedvideos', $relatedvideos);
		
		JSubMenuHelper::addEntry(JText::_('General Settings'), 'index.php?option=com_jomwebplayer&view=settings', true);
		JSubMenuHelper::addEntry(JText::_('Category'), 'index.php?option=com_jomwebplayer&view=category');
		JSubMenuHelper::addEntry(JText::_('Videos'), 'index.php?option=com_jomwebplayer&view=videos');		
		JSubMenuHelper::addEntry(JText::_('Google Adsense'), 'index.php?option=com_jomwebplayer&view=googleads');
		
		JToolBarHelper::title(JText::_('Jom Webplayer'), 'jomwebplayer');
        JToolBarHelper::save('save', 'Save');		
		
        parent::display($tpl);
    }
	
	function buildSelectBox($id, $val) {
		$options[] = JHTML::_('select.option', 1, JText::_('Yes'));
		$options[] = JHTML::_('select.option', 0, JText::_('No'));
		
		return JHTML::_('select.genericlist', $options, $id, '', 'value', 'text', $val);
	}
	
}

?>