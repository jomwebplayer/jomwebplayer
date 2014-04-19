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

class JomWebplayerViewVideos extends JomWebplayerView {

    function display($tpl = null) {
		$mainframe  = JFactory::getApplication();	
		$option     = JRequest::getCmd('option');
		$view       = JRequest::getCmd('view');
	    $model      = $this->getModel();
		
		$limit      = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart = $mainframe->getUserStateFromRequest($option.$view.'.limitstart', 'limitstart', 0, 'int');
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);
		$this->assignRef('limitstart', $limitstart);
		
        $data  = $model->getvideos();
		$this->assignRef('data', $data);
		
		$category_options[]     = JHTML::_('select.option', 'none', JText::_('None'));
		$categories             = $model->getcategories();		 
		foreach ( $categories as $item ) {
			$item->treename     = JString::str_ireplace('&#160;', '-', $item->treename);
			$category_options[] = JHTML::_('select.option', $item->name, $item->treename );
		}
		$category = JHTML::_('select.genericlist', $category_options, 'category', '', 'value', 'text', '');
		$this->assignRef('category', $category);
		
		$pagination = $model->getpagination();
		$this->assignRef('pagination', $pagination);
		
		$lists = $model->getlists();
		$this->assignRef('lists', $lists);
		
		$approval = $model->getapproval();
		$this->assignRef('approval', $approval);
		
		JSubMenuHelper::addEntry(JText::_('General Settings'), 'index.php?option=com_jomwebplayer&view=settings');
		JSubMenuHelper::addEntry(JText::_('Category'), 'index.php?option=com_jomwebplayer&view=category');
		JSubMenuHelper::addEntry(JText::_('Videos'), 'index.php?option=com_jomwebplayer&view=videos', true);		
		JSubMenuHelper::addEntry(JText::_('Google Adsense'), 'index.php?option=com_jomwebplayer&view=googleads');
		
		JToolBarHelper::title(JText::_('Jom Webplayer'), 'jomwebplayer');
        JToolBarHelper::publishList();
        JToolBarHelper::unpublishList();
        JToolBarHelper::deleteList('','delete');
        JToolBarHelper::editList('edit');
        JToolBarHelper::addNew('add');		
				
		parent::display($tpl);
		
    }
	
	function add($tpl = null) {
	    $model = $this->getModel();
		
		$category_options[]     = JHTML::_('select.option', 'none', JText::_('Uncategorised'));
		$categories             = $model->getcategories();		 
		foreach ( $categories as $item ) {
			$item->treename     = JString::str_ireplace('&#160;', '-', $item->treename);
			$category_options[] = JHTML::_('select.option', $item->name, $item->treename );
		}
		$category = JHTML::_('select.genericlist', $category_options, 'category', '', 'value', 'text', '');
		$this->assignRef('category', $category);
		
		JToolBarHelper::title(JText::_('Jom Webplayer'), 'jomwebplayer');
        JToolBarHelper::save('save', 'Save');
        JToolBarHelper::apply('apply', 'Apply');
        JToolBarHelper::cancel('cancel');		
				
		parent::display($tpl);
		
    }
	
	function edit($tpl = null) {
	    $model = $this->getModel();
		
        $data  = $model->getrow();
		$this->assignRef('data', $data);
		
		$category_options[]     = JHTML::_('select.option', 'none', JText::_('Uncategorised'));
		$categories             = $model->getcategories();		 
		foreach ( $categories as $item ) {
			$item->treename     = JString::str_ireplace('&#160;', '-', $item->treename);
			$category_options[] = JHTML::_('select.option', $item->name, $item->treename );
		}
		$category = JHTML::_('select.genericlist', $category_options, 'category', '', 'value', 'text', $data->category);
		$this->assignRef('category', $category);
		
		JToolBarHelper::title(JText::_('Jom Webplayer'), 'jomwebplayer');
        JToolBarHelper::save('save', 'Save');
        JToolBarHelper::apply('apply', 'Apply');
        JToolBarHelper::cancel('cancel');		
		
        parent::display($tpl);
    }
	
}

?>