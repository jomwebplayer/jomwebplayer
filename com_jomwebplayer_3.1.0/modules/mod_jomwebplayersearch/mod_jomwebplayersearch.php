<?php

/*
 * @version		$Id: mod_jomwebplayersearch.php 3.1.0 2012-10-28 $
 * @package		Joomla
 * @subpackage	jomwebplayer
 * @copyright   Copyright (C) 2012-2014 Jom Webplayer
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>

<div align="center">
  <form action="<?php echo JRoute::_('index.php?option=com_jomwebplayer&view=search'); ?>" name="hsearch" id="hsearch" method="post" enctype="multipart/form-data"  >
    <input type="text" name="jomwebplayersearch" id="jomwebplayersearch" style="width:75%" value="" />
    <input type="submit" name="search_btn" id="search_btn" value="Go" />
  </form>
</div>