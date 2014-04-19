<?php 

/*
 * @version		$Id: embed.php 3.1.0 2012-10-28 $
 * @package		Joomla
 * @subpackage	jomwebplayer
 * @copyright   Copyright (C) 2012-2014 Jom Webplayer
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access'); 

require_once JPATH_ROOT.'/'.'components'.'/'.'com_jomwebplayer'.'/'.'models'.'/'.'html5.php'; 
require_once JPATH_ROOT.'/'.'components'.'/'.'com_jomwebplayer'.'/'.'models'.'/'.'isMobile.php';

srand ((double) microtime( )*1000000);
$dyn      = rand( );
$contents = '';
$htmlNode = '';
$html5Obj = array();

if(JRequest::getCmd('wid')) {
	$id = JRequest::getCmd('wid');
} else {
	$id = '';
}

if($video == '') {
	$html5     = new JomWebplayerModelHtml5();
	$html5Obj  = $html5->getvideo($id, $category);
	$video     = $html5Obj[0]->video;
	$streamer  = $html5Obj[0]->streamer;
} else {
	$_type = $type ? $type : 'video';
	$html5Obj[0]->type = $_type;
	if($_type != 'youtube') {
		$html5Obj[0]->ext = end(explode(".", $video));
	} else {
		$html5Obj[0]->ext = '';
	}
}

if($video == '') {
	$key = 'category';
	$flashvars  = preg_replace('/(.*)(\?|&)' . $key . '=[^&]+?(&)(.*)/i', '$1$2$4', $flashvars . '&'); 
	$flashvars  = substr($flashvars, 0, -1); 
	$flashvars .= '&playListXml=&playList=false&video=video.flv';
}

switch($html5Obj[0]->type) {
	case 'Youtube Videos' :
	    $url_string = parse_url($video, PHP_URL_QUERY);
  	    parse_str($url_string, $args);
	    $htmlNode  = '<iframe title="YouTube video player" width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/'.$args['v'].'" frameborder="0" allowfullscreen></iframe>';
		break;
	case 'Dailymotion Videos':
	 	$htmlNode  = '<iframe frameborder="0" width="'.$width.'" height="'.$height.'" src="'.$video.'"></iframe>';
		break;
	case 'RTMP Streams':
		$url_string = str_replace('rtmp', 'http', $streamer).'/'.$video.'/playlist.m3u8';
	 	$htmlNode   = '<video onclick="this.play();" width="'.$width.'" height="'.$height.'" controls>';
  	    $htmlNode  .= '<source src="'.$url_string.'" />';
		$htmlNode  .= '</video>';
		break;
	default :
	    if($html5Obj[0]->ext == 'mp4' || $html5Obj[0]->ext == 'm4v') {
	    	$htmlNode  = '<video onclick="this.play();" width="'.$width.'" height="'.$height.'" controls>';
  	    	$htmlNode .= '<source src="'.$video.'" />';
			$htmlNode .= '</video>';
		}		
}

if($ad == 1) {
	$cont    = "ad_container_".$dyn;
	$overlay = "ad_overlay_".$dyn;
	
	$style   = '';	
		
	$style  .= '<style type="text/css">';
		
    $style  .= '#video_wrapper {';
    $style  .= 'width:'.$width.'px;';
    $style  .= 'height:'.$height.'px;';
    $style  .= '}';
	
    $style  .= '#video_wrapper .ad_container_'.$dyn.' {';
 	$style  .= 'margin:'.($height/2 - 154).'px '.($width/2 - 150).'px;';
	$style  .= 'position:absolute;';
	$style  .= 'z-index:10001;';
    $style  .= '}';
		
    $style  .= '#video_wrapper .ad_container_'.$dyn.' .ad_header {';
	$style  .= 'background:#999;';
	$style  .= 'padding:5px 0;';
	$style  .= 'text-align:center;';
	$style  .= 'color:#fff;';
	$style  .= 'font-size:12px;';
	$style  .= 'font-weight:bold;';
	$style  .= 'width:300px;';
    $style  .= '}';
	
	$style  .= '#video_wrapper .ad_container_'.$dyn.' .ad_content {';
	$style  .= 'width:300px;';
	$style  .= 'height:250px;';
	$style  .= 'text-align:center;';
	$style  .= 'background:#fff;';
    $style  .= '}';
		
	$style  .= '#video_wrapper .ad_container_'.$dyn.' .ad_footer {';
	$style  .= 'background:#999;';
	$style  .= 'padding:5px 0;';
	$style  .= 'text-align:center;';
	$style  .= 'color:#fff;';
	$style  .= 'width:300px;';
    $style  .= '}';
	
	$style  .= '#video_wrapper .ad_overlay_'.$dyn.' {';
	$style  .= 'background:#000;';
	$style  .= 'filter:alpha(opacity=75);';
	$style  .= '-moz-opacity:.75;';
	$style  .= 'opacity:.75;';
 	$style  .= 'width:'.$width.'px;';
	$style  .= 'height:'.$height.'px;';
	$style  .= 'position:absolute;';
    $style  .= '}';
	
	$style  .= '#player_div {';
	$style  .= 'z-index:0;';
	$style  .= 'position:absolute;';
    $style  .= '}';
		 
    $style  .= '</style>';
	
	echo $style;
	
	$contents .= '<div id="video_wrapper" >';
    $contents .= '<div id="ad_container_'.$dyn.'" class="ad_container_'.$dyn.'">';
    $contents .= '<div class="ad_header" id="ad_header" >Advertisement </div>';
    $contents .= '<div class="ad_content" id="ad_content">' .$googleads->adscript.' </div>';
    $contents .= '<div class="ad_footer" id="ad_footer"> <a href="javascript:hideAd(\''.$cont.'\', \''.$overlay.'\');">';
	$contents .= '<img src="'.JURI::root().'components/com_jomwebplayer/assets/btn_close.gif" border="0" /></a> </div>';
    $contents .= '</div>';
    $contents .= '<div id="player_div">';
}
$detect = new Mobile_Detect();
if ($detect->isMobile()) {
    $contents  .= '<p>'.$htmlNode.'</p>';
} else {
	$src = JURI::root() . 'components/com_jomwebplayer/player.swf?r=' . rand();
	$contents  .= '<object id="player" name="player" width="'.$width.'" height="'.$height.'">';
	$contents  .= '<param name="movie" value="'.$src.'" />';
	$contents  .= '<param name="wmode" value="opaque" />';
	$contents  .= '<param name="allowfullscreen" value="true" />';
	$contents  .= '<param name="allowscriptaccess" value="always" />';
	$contents  .= '<param name="flashvars" value="'.$flashvars.'" />';
	$contents  .= '<object type="application/x-shockwave-flash" data="'.$src.'" width="'.$width.'" height="'.$height.'">';
	$contents  .= '<param name="movie" value="'.$src.'" />';
	$contents  .= '<param name="wmode" value="opaque" />';
	$contents  .= '<param name="allowfullscreen" value="true" />';
	$contents  .= '<param name="allowscriptaccess" value="always" />';
	$contents  .= '<param name="flashvars" value="'.$flashvars.'" />';
	$contents  .= '</object>';
	$contents  .= '</object>';
}
if($ad == 1) {
	$contents .= '</div>';
    $contents .= '<div id="ad_overlay_'.$dyn.'" class="ad_overlay_'.$dyn.'"></div>';
    $contents .= '</div>';
}

?>