<?php 

/*
 * @version		$Id: default.php 3.1.0 2012-10-28 $
 * @package		Joomla
 * @subpackage	jomwebplayer
 * @copyright   Copyright (C) 2012-2014 Jom Webplayer
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access'); 

$player    = $this->settings;
$googleads = $this->googleads;
$width     = $this->player_width;
$height    = $this->player_height;
$lang      = JRequest::getCmd('lang') ? '&lang='.JRequest::getCmd('lang') : '';
$video     = '';
$category  = '';
$plugin    = true;
$src       = COM_JOMWEBPLAYER_BASEURL.'&view=player'.$lang;
$flashvars = 'baseJ='.JURI::root();
$flashvars .= JRequest::getCmd('wid') ? '&id='.JRequest::getCmd('wid')  : '' ;

if($googleads->component == 1 && $width >= 350 && $height >= 350) {
	$ad = 1;
} else {
	$ad = 0;
}
require JPATH_ROOT.DS.'components'.DS.'com_jomwebplayer'.DS.'models'.DS.'embed.php';

$document = JFactory::getDocument();
$document->addStyleSheet( JURI::root() . "components/com_jomwebplayer/css/jomwebplayer.css",'text/css',"screen");
$document->addScript( JURI::root() . "components/com_jomwebplayer/js/jomwebplayer.js" );
$document->addScript( "http://code.jquery.com/jquery-latest.js" );

?>

<?php if($this->show_title) : ?>
	<h2 id="jomwebplayer_title">&nbsp;</h2>
<?php endif; ?>
<div id="jomwebplayer_video">
	<?php echo $contents; ?>
</div>
<?php if($this->show_description) : ?>
	<div id="jomwebplayer_description">&nbsp;</div>
<?php endif; ?>