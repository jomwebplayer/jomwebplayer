<?php

/*
 * @version		$Id: uninstall.jomwebplayer.php 3.1.0 2012-10-28 $
 * @package		Joomla
 * @subpackage	jomwebplayer
 * @copyright   Copyright (C) 2012-2014 Jom Webplayer
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.installer.installer');

if (version_compare(JVERSION, '1.6.0', '<')) {
	$status = new JObject();
	$status->modules = array();
	$status->plugins = array();

	$db = JFactory::getDBO();
	// -- UnInstall Modules
	$mname = "mod_jomwebplayer";
	$query = "SELECT `id` FROM `#__modules` WHERE module = ".$db->Quote($mname);
	$db->setQuery($query);
	$modules = $db->loadResultArray();
	if (count($modules)) {
		foreach ($modules as $module) {
			$installer = new JInstaller;
			$result = $installer->uninstall('module', $module);
		}
		$status->modules[] = array('name'=>$mname, 'client'=>'site', 'result'=>$result);
	}
	
	$mname = "mod_jomwebplayergallery";
	$query = "SELECT `id` FROM `#__modules` WHERE module = ".$db->Quote($mname);
	$db->setQuery($query);
	$modules = $db->loadResultArray();
	if (count($modules)) {
		foreach ($modules as $module) {
			$installer = new JInstaller;
			$result = $installer->uninstall('module', $module);
		}
		$status->modules[] = array('name'=>$mname, 'client'=>'site', 'result'=>$result);
	}
	
	$mname = "mod_jomwebplayerupload";
	$query = "SELECT `id` FROM `#__modules` WHERE module = ".$db->Quote($mname);
	$db->setQuery($query);
	$modules = $db->loadResultArray();
	if (count($modules)) {
		foreach ($modules as $module) {
			$installer = new JInstaller;
			$result = $installer->uninstall('module', $module);
		}
		$status->modules[] = array('name'=>$mname, 'client'=>'site', 'result'=>$result);
	}
	
	$mname = "mod_jomwebplayersearch";
	$query = "SELECT `id` FROM `#__modules` WHERE module = ".$db->Quote($mname);
	$db->setQuery($query);
	$modules = $db->loadResultArray();
	if (count($modules)) {
		foreach ($modules as $module) {
			$installer = new JInstaller;
			$result = $installer->uninstall('module', $module);
		}
		$status->modules[] = array('name'=>$mname, 'client'=>'site', 'result'=>$result);
	}

	// -- UnInstall Plugin
	$pname = 'jomwebplayer';	
	$query = 'SELECT `id` FROM #__plugins WHERE element = '.$db->Quote($pname);
	$db->setQuery($query);
	$plugins = $db->loadResultArray();
	if (count($plugins)) {
		foreach ($plugins as $plugin) {
			$installer = new JInstaller;
			$result = $installer->uninstall('plugin', $plugin, 0);
		}
	}
	$status->plugins[] = array('name'=>$pname,'group'=>'content', 'result'=>$result);
}
	
?>
<?php if (version_compare(JVERSION, '1.6.0', '<')): ?>
<?php $rows = 0; ?>
<style type="text/css">
#jomwebplayer_uninstall table thead tr th, #jomwebplayer_uninstall table tbody tr th {
	height:25px;
	font-size:12px;
	font-weight:bold;
	padding:5px 0px 5px 10px;
	background:#F0F0F0;
	border:1px solid #E7E7E7;
}
#jomwebplayer_uninstall table tbody tr td {
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
<div id="jomwebplayer_uninstall">
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
        <td><strong><?php echo JText::_('Removed'); ?></strong></td>
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
        <td><strong><?php echo ($module['result'])?JText::_('Removed'):JText::_('Not removed'); ?></strong></td>
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
        <td><strong><?php echo ($plugin['result'])?JText::_('Removed'):JText::_('Not removed'); ?></strong></td>
      </tr>
      <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>
<?php endif; ?>