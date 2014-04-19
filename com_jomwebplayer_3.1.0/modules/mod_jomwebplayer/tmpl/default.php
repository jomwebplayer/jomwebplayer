<?php 

/*
 * @version		$Id: default.php 3.1.0 2012-10-28 $
 * @package		Joomla
 * @subpackage	jomwebplayer
 * @copyright   Copyright (C) 2012-2014 Jom Webplayer
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

$width      = $items['width'];
$height     = $items['height'];
$category   = ($items['categories'] == '') ? '' : implode("%2C", $items['categories']);
$video      = '';
$flashvars  = 'baseJ='.JURI::root();
$flashvars .= ($category != '') ? '&category='.$category : '';
$flashvars .= ($items['autoStart'] == 0) ? '&autoStart=false' : '&autoStart=true';
$flashvars .= ($items['skinMode'] == 'float') ? '&skinMode=float' : '&skinMode=static';
$flashvars .= ($items['playListAutoStart'] == 1) ? '&playListAutoStart=true' : '&playListAutoStart=false';
$flashvars .= ($items['playListOpen'] == 1) ? '&playListOpen=true' : '&playListOpen=false';
$flashvars .= ($items['playListRandom'] == 1) ? '&playListRandom=true' : '&playListRandom=false';
$flashvars .= ($items['buffer'] != '') ? '&buffer='.$items['buffer'] : '&buffer=3';
$flashvars .= ($items['volumeLevel'] != '') ? '&volumeLevel='.$items['volumeLevel'] : '&volumeLevel=50';
$flashvars .= ($items['stretch'] != '') ? '&stretch='.$items['stretch'] : '&stretch=fill';
$flashvars .= ($items['controlBar'] != '' && $items['controlBar'] == 0) ? '&controlBar=false' : '&controlBar=true';
$flashvars .= ($items['playPauseDock'] != '' && $items['playPauseDock'] == 0) ? '&playPauseDock=false' : '&playPauseDock=true';
$flashvars .= ($items['progressBar'] != '' && $items['progressBar'] == 0) ? '&progressBar=false' : '&progressBar=true';
$flashvars .= ($items['timerDock'] != '' && $items['timerDock'] == 0) ? '&timerDock=false' : '&timerDock=true';
$flashvars .= ($items['shareDock'] != '' && $items['shareDock'] == 0) ? '&shareDock=false' : '&shareDock=true';
$flashvars .= ($items['volumeDock'] != '' && $items['volumeDock'] == 0) ? '&volumeDock=false' : '&volumeDock=true';
$flashvars .= ($items['fullScreenDock'] != '' && $items['fullScreenDock'] == 0) ? '&fullScreenDock=false' : '&fullScreenDock=true';
$flashvars .= ($items['playDock'] != '' && $items['playDock'] == 0) ? '&playDock=false' : '&playDock=true';
$flashvars .= ($items['playList'] != '' && $items['playList'] == 0) ? '&playList=false' : '&playList=true';
$flashvars .= ($items['autodetect'] == 1 && JRequest::getCmd('wid')) ? '&id='.JRequest::getCmd('wid') : '' ;

$uid = $module->id;
$flashvars .= '&uid='.$uid;

if($googleads->module == 1 && $width  >= 350 && $height >= 350) {
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

<?php if($items['showtitle']) : ?>
	<h2 id="jomwebplayer_title<?php echo $uid; ?>" style="width:<?php echo $width; ?>px;">&nbsp;</h2>
<?php endif; ?>
<div id="jomwebplayer_video"><?php echo $contents; ?></div>
<?php if($items['showdescription']) : ?>
	<div id="jomwebplayer_description<?php echo $uid; ?>" style="width:<?php echo $width; ?>px;">&nbsp;</div>
<?php endif; ?>