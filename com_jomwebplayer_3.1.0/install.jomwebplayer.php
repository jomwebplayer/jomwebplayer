<?php

/*
 * @version		$Id: install.jomwebplayer.php 3.1.0 2012-10-28 $
 * @package		Joomla
 * @subpackage	jomwebplayer
 * @copyright   Copyright (C) 2012-2014 Jom Webplayer
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

if (version_compare(JVERSION, '1.6.0', '<')) {
	jimport('joomla.installer.installer');

	$status = new JObject();
	$status->modules = array();
	$status->plugins = array();
	$src = $this->parent->getPath('source');

	// Install Modules
	$mname = 'mod_jomwebplayer';
	$installer = new JInstaller;
	$result = $installer->install($src.DS.'modules'.DS.$mname);
	$status->modules[] = array('name'=>$mname,'client'=>'site', 'result'=>$result);

	$mname = 'mod_jomwebplayergallery';
	$installer = new JInstaller;
	$result = $installer->install($src.DS.'modules'.DS.$mname);
	$status->modules[] = array('name'=>$mname,'client'=>'site', 'result'=>$result);

	$mname = 'mod_jomwebplayerupload';
	$installer = new JInstaller;
	$result = $installer->install($src.DS.'modules'.DS.$mname);
	$status->modules[] = array('name'=>$mname,'client'=>'site', 'result'=>$result);

	$mname = 'mod_jomwebplayersearch';
	$installer = new JInstaller;
	$result = $installer->install($src.DS.'modules'.DS.$mname);
	$status->modules[] = array('name'=>$mname,'client'=>'site', 'result'=>$result);
	
	// Install Plugin
	$pname = 'jomwebplayer';
	$installer = new JInstaller;
	$result = $installer->install($src.DS.'plugins'.DS.'jomwebplayer');
	$status->plugins[] = array('name'=>$pname,'group'=>'content', 'result'=>$result);

	// Database modifications [start]
	$db = JFactory::getDBO();
	$query = "SELECT COUNT(*) FROM #__jomwebplayer_settings";
	$db->setQuery($query);
	$num = $db->loadResult();

	if ($num==0) {
		$query = "INSERT INTO `#__jomwebplayer_videos` (`id`, `title`, `type`, `streamer`, `video`, `preview`, `thumb`, `category`, `published`) VALUES (NULL, 'Sample Video', 'Direct URL', '', 'http://jomwebplayer.com/player/videos/300.mp4', 'http://img.youtube.com/vi/HdNn5TZu6R8/default.jpg', 'http://img.youtube.com/vi/HdNn5TZu6R8/0.jpg', 'none', '1')";
		$db->setQuery($query);
		$db->Query();
	
		$query = "INSERT INTO `#__jomwebplayer_settings` (`id`, `width`, `height`, `licensekey`, `logo`, `logoposition`, `logoalpha`, `logotarget`, `skinmode`, `stretchtype`, `buffertime`, `volumelevel`, `autoplay`, `playlistautoplay`, `ffmpeg`, `flvtool2`) VALUES (NULL, '640', '360', 'Your Commercial Key Here', '', 'topleft', '35', 'http://jomwebplayer.com', 'static', 'fill', '3', '50', '0', '0', '/usr/bin/ffmpeg/', '/usr/bin/flvtool2/')";
		$db->setQuery($query);
		$db->Query();
	
		$query = "INSERT INTO `#__jomwebplayer_skin` (`id`, `controlbar`, `playpause`, `progressbar`, `timer`, `share`, `volume`, `fullscreen`, `playdock`, `videogallery`) VALUES (NULL, '1', '1', '1', '1', '1', '1', '1', '1', '1')";
		$db->setQuery($query);
		$db->Query();
	
		$query = "INSERT INTO `#__jomwebplayer_googleads` (`id`, `adscript`, `component`, `module`, `plugin`) VALUES
(1, '', 0, 0, 0);";
    	$db->setQuery($query);
		$db->Query();
	}

	// Get Table Fields for Update		
	$fields_settings = $db->getTableFields('#__jomwebplayer_settings');
	$fields_videos   = $db->getTableFields('#__jomwebplayer_videos');
	$fields_category = $db->getTableFields('#__jomwebplayer_category');
	
	
	if (!array_key_exists('playlistopen', $fields_settings['#__jomwebplayer_settings'])) {
		$query = "ALTER TABLE #__jomwebplayer_settings ADD `playlistopen` TINYINT(4) NOT NULL, ADD `ffmpeg` VARCHAR(255) NOT NULL DEFAULT '/usr/bin/ffmpeg/', ADD `flvtool2` VARCHAR(255) NOT NULL DEFAULT '/usr/bin/flvtool2/' AFTER `playlistautoplay`";
		$db->setQuery($query);
		$db->query();
	}

	if (!array_key_exists('hdvideo', $fields_videos['#__jomwebplayer_videos'])) {
		$query = "ALTER TABLE #__jomwebplayer_videos ADD `hdvideo` VARCHAR(255) NOT NULL AFTER `video`";
		$db->setQuery($query);
		$db->query();
	}

	if (!array_key_exists('ordering', $fields_videos['#__jomwebplayer_videos'])) {
		$query = "ALTER TABLE #__jomwebplayer_videos ADD `ordering` INT(5) NOT NULL DEFAULT '1' AFTER `category`";
		$db->setQuery($query);
		$db->query();
	}

	if (!array_key_exists('token', $fields_videos['#__jomwebplayer_videos'])) {
		$query = "ALTER TABLE #__jomwebplayer_videos ADD `token` VARCHAR(255) NOT NULL AFTER `thumb`";
		$db->setQuery($query);
		$db->query();
	}

	if (!array_key_exists('type', $fields_category['#__jomwebplayer_category'])) {
		$query = "ALTER TABLE #__jomwebplayer_category ADD `type` VARCHAR(255) NOT NULL DEFAULT 'Url', ADD `image` VARCHAR(255) NOT NULL AFTER `name`";
		$db->setQuery($query);
		$db->query();
	}

	if (!array_key_exists('featured', $fields_videos['#__jomwebplayer_videos'])) {
		$query = "ALTER TABLE #__jomwebplayer_videos ADD `featured` TINYINT(4) NOT NULL, ADD `views` int(5) NOT NULL AFTER `category`";
		$db->setQuery($query);
		$db->query();
	}

	if (!array_key_exists('user', $fields_videos['#__jomwebplayer_videos'])) {
		$query = "ALTER TABLE #__jomwebplayer_videos ADD `user` VARCHAR(255) NOT NULL DEFAULT 'Admin', ADD `tags` VARCHAR(255) NOT NULL AFTER `featured`";
		$db->setQuery($query);
		$db->query();
	}

	if (!array_key_exists('dvr', $fields_videos['#__jomwebplayer_videos'])) {
		$query = "ALTER TABLE #__jomwebplayer_videos ADD `dvr` TINYINT(4) NOT NULL AFTER `streamer`";
		$db->setQuery($query);
		$db->query();
	}

	if (!array_key_exists('playlistrandom', $fields_settings['#__jomwebplayer_settings'])) {
		$query = "ALTER TABLE #__jomwebplayer_settings ADD `playlistrandom` TINYINT(4) NOT NULL AFTER `playlistopen`";
		$db->setQuery($query);
		$db->query();
	}

	if (!array_key_exists('title', $fields_settings['#__jomwebplayer_settings'])) {
		$query = "ALTER TABLE #__jomwebplayer_settings ADD `title` TINYINT(4) NOT NULL DEFAULT '1', ADD `description` TINYINT(4) NOT NULL DEFAULT '1' AFTER `height`";
		$db->setQuery($query);
		$db->query();
	}

	if (!array_key_exists('qtfaststart', $fields_settings['#__jomwebplayer_settings'])) {
		$query = "ALTER TABLE #__jomwebplayer_settings ADD `qtfaststart` VARCHAR(255) NOT NULL DEFAULT '/usr/bin/qt-faststart/', ADD `rows` INT(5) NOT NULL DEFAULT '3', ADD `cols` INT(5) NOT NULL DEFAULT '3', ADD `thumbwidth` INT(5) NOT NULL DEFAULT '145', ADD `thumbheight` INT(5) NOT NULL DEFAULT '80', ADD `subcategories` TINYINT(4) NOT NULL DEFAULT '1', ADD `relatedvideos` TINYINT(4) NOT NULL DEFAULT '1' AFTER `flvtool2`";
		$db->setQuery($query);
		$db->query();
	}

	if (!array_key_exists('description', $fields_videos['#__jomwebplayer_videos'])) {
		$query = "ALTER TABLE #__jomwebplayer_videos ADD `description` TEXT NOT NULL DEFAULT '' AFTER `title`";
		$db->setQuery($query);
		$db->query();
	}

	if (!array_key_exists('metadescription', $fields_videos['#__jomwebplayer_videos'])) {
		$query = "ALTER TABLE #__jomwebplayer_videos ADD `metadescription` TEXT NOT NULL DEFAULT '' AFTER `tags`";
		$db->setQuery($query);
		$db->query();
	}

	if (!array_key_exists('parent', $fields_category['#__jomwebplayer_category'])) {
		$query = "ALTER TABLE #__jomwebplayer_category ADD `parent` INT(10) NOT NULL DEFAULT '0', ADD `ordering` INT(5) NOT NULL DEFAULT '0' AFTER `name`";
		$db->setQuery($query);
		$db->query();
	}

	if (!array_key_exists('metakeywords', $fields_category['#__jomwebplayer_category'])) {
		$query = "ALTER TABLE #__jomwebplayer_category ADD `metakeywords` TEXT NOT NULL DEFAULT '', ADD `metadescription` TEXT NOT NULL DEFAULT '' AFTER `image`";
		$db->setQuery($query);
		$db->query();
	}
	// Database modifications [end]	
	
	if (JFile::exists(JPATH_ADMINISTRATOR . '/components/com_jomwebplayer/admin.jomwebplayer.php')) {
		JFile::delete(JPATH_ADMINISTRATOR . '/components/com_jomwebplayer/admin.jomwebplayer.php');
	}
	
	if (JFile::exists(JPATH_ADMINISTRATOR . '/components/com_jomwebplayer/toolbar.jomwebplayer.html.php')) {
		JFile::delete(JPATH_ADMINISTRATOR . '/components/com_jomwebplayer/toolbar.jomwebplayer.html.php');
	}
	
	if (JFile::exists(JPATH_ADMINISTRATOR . '/components/com_jomwebplayer/toolbar.jomwebplayer.php')) {
		JFile::delete(JPATH_ADMINISTRATOR . '/components/com_jomwebplayer/toolbar.jomwebplayer.php');
	}
	
	if (JFile::exists(JPATH_ROOT . '/components/com_jomwebplayer/views/default/tmpl/default.inc.php')) {
		JFile::delete(JPATH_ROOT . '/components/com_jomwebplayer/views/default/tmpl/default.inc.php');
	}
}
?>
<?php if (version_compare(JVERSION, '1.6.0', '<')): ?>
<?php $rows = 0; ?>
<style type="text/css">
#jomwebplayer_install table thead tr th, #jomwebplayer_install table tbody tr th {
	height:25px;
	font-size:12px;
	font-weight:bold;
	padding:5px 0px 5px 10px;
	background:#F0F0F0;
	border:1px solid #E7E7E7;
}
#jomwebplayer_install table tbody tr td {
	height:25px;
	font-size:11px;
	font-weight:normal;
	padding:5px 0px 5px 10px;
	background:#FFFFFF;
	border:1px solid #E7E7E7;
	color:#333;
	font-style:italic;
}
</style>
<div id="jomwebplayer_install">
  <table cellspacing="1" cellpadding="0" width="100%">
    <thead>
      <tr>
        <th class="title" colspan="2"><?php echo JText::_('Extension'); ?></th>
        <th width="30%"><?php echo JText::_('Status'); ?></th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <td colspan="3"></td>
      </tr>
    </tfoot>
    <tbody>
      <tr class="row0">
        <td class="key" colspan="2"><?php echo 'Jom Webplayer '.JText::_('Component'); ?></td>
        <td><strong><?php echo JText::_('Installed'); ?></strong></td>
      </tr>
      <?php if (count($status->modules)) : ?>
      <tr>
        <th><?php echo JText::_('Module'); ?></th>
        <th><?php echo JText::_('Client'); ?></th>
        <th></th>
      </tr>
      <?php foreach ($status->modules as $module) : ?>
      <tr class="row<?php echo (++ $rows % 2); ?>">
        <td class="key"><?php echo $module['name']; ?></td>
        <td class="key"><?php echo ucfirst($module['client']); ?></td>
        <td><strong><?php echo ($module['result'])?JText::_('Installed'):JText::_('Not installed'); ?></strong></td>
      </tr>
      <?php endforeach;?>
      <?php endif;?>
      <?php if (count($status->plugins)) : ?>
      <tr>
        <th><?php echo JText::_('Plugin'); ?></th>
        <th><?php echo JText::_('Group'); ?></th>
        <th></th>
      </tr>
      <?php foreach ($status->plugins as $plugin) : ?>
      <tr class="row<?php echo (++ $rows % 2); ?>">
        <td class="key"><?php echo ucfirst($plugin['name']); ?></td>
        <td class="key"><?php echo ucfirst($plugin['group']); ?></td>
        <td><strong><?php echo ($plugin['result'])?JText::_('Installed'):JText::_('Not installed'); ?></strong></td>
      </tr>
      <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>
<?php endif; ?>