<?php 

/*
 * @version		$Id: default.php 3.1.0 2012-10-28 $
 * @package		Joomla
 * @subpackage	jomwebplayer
 * @copyright   Copyright (C) 2012-2014 Jom Webplayer
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access'); 

$player     = $this->settings;
$googleads  = $this->googleads;
$width      = $this->player_width;
$height     = $this->player_height;
$video      = '';
$category   = $this->category;
$flashvars  = 'baseJ='.JURI::root();
$flashvars .= JRequest::getCmd('wid') ? '&id='.JRequest::getCmd('wid')  : '' ;
$flashvars .= ($this->autostart == 0) ? '&autoStart=false' : '&autoStart=true';
$flashvars .= ($this->playlist_autostart == 1) ? '&playListAutoStart=true' : '&playListAutoStart=false';
$flashvars .= '&playListRandom=false';
$flashvars .= ($category) ? '&category='.$category : '';

if($googleads->component == 1 && $width >= 350 && $height >= 350) {
	$ad = 1;
} else {
	$ad = 0;
}
require JPATH_ROOT.DS.'components'.DS.'com_jomwebplayer'.DS.'models'.DS.'embed.php';

$this->generateMetaTags( $this->params, $html5Obj[0] );
$this->generateBreadcrumbs( $this->params, $html5Obj[0] );

$document = JFactory::getDocument();
$document->addStyleSheet( JURI::root() . "components/com_jomwebplayer/css/jomwebplayer.css",'text/css',"screen");
$document->addScript( JURI::root() . "components/com_jomwebplayer/js/jomwebplayer.js" );
$document->addScript( "http://code.jquery.com/jquery-latest.js" );

?>

<?php if($this->show_title) : ?>
	<h2 id="jomwebplayer_title" style="width:<?php echo $width; ?>px;">&nbsp;</h2>
<?php endif; ?>
<div id="jomwebplayer_video">
	<?php echo $contents; ?>
</div>
<?php if($this->show_description) : ?>
	<div id="jomwebplayer_description" style="width:<?php echo $width; ?>px;">&nbsp;</div>
<?php endif; ?>
<?php echo $this->loadTemplate('related'); ?>