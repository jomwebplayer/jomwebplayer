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

class JomWebplayerViewVideos extends JomWebplayerView {

	function display($tpl = null) {
		$mainframe = JFactory::getApplication();
		$model 	   = $this->getModel();		

		$settings  = $model->getsettings();

		$params = $mainframe->getParams();
		$this->assignRef('params',	$params);
		
		$rows = $params->get('no_of_rows', $settings->rows);		
		$this->assignRef('rows', $rows);
		
		$cols = $params->get('no_of_cols', $settings->cols);
		$this->assignRef('cols', $cols);
		
		$thumb_width = $params->get('thumb_width', $settings->thumbwidth);
		$this->assignRef('thumb_width', $thumb_width);
		
		$thumb_height = $params->get('thumb_height', $settings->thumbheight);
		$this->assignRef('thumb_height', $thumb_height);
		
		if(substr(JVERSION,0,3) != '1.5') {
			$doc = JFactory::getDocument();
			if ($params->get('menu-meta_description')) {
				$doc->setDescription($params->get('menu-meta_description'));
			}

			if ($params->get('menu-meta_keywords')) {
				$doc->setMetadata('keywords', $params->get('menu-meta_keywords'));
			}

			if ($params->get('robots')) {
				$doc->setMetadata('robots', $params->get('robots'));
			}
		}
		
		$videos = $model->getvideos($rows * $cols);
		$this->assignRef('videos', $videos);
		
		$pagination = $model->getpagination();
		$this->assignRef('pagination', $pagination);
				
        parent::display($tpl);
    }
	
}

?>