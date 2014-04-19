<?php

/*
 * @version		$Id: default.php 3.1.0 2012-10-28 $
 * @package		Joomla
 * @subpackage	jomwebplayer
 * @copyright   Copyright (C) 2012-2014 Jom Webplayer
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');
$settings = $this->settings;
$skin = $this->skin[0];
?>

<div id="jomwebplayer">
  <div style="background-color:#FFFFDD; margin:0px; padding:10px; text-align:center;">
  	<p style="margin:0px; font-size:12px;"><strong>You have installed -</strong> Jom Webplayer <strong style="color:#ba0000">3.1.0</strong> version</p>
  	<p style="margin:5px 0px 0px 0px; font-size:11px;">
    	Copyright (c) 2012 - 2014 <a href="http://jomwebplayer.com/" target="_blank">Jom Webplayer</a>. All rights reserved.&nbsp;&nbsp; 
        <strong>Website : </strong><a href="http://jomwebplayer.com/" target="_blank">jomwebplayer.com</a>&nbsp;&nbsp;
        <strong>Support mail : </strong>admin@jomwebplayer.com
    </p>
  </div>
  <form action="index.php?option=com_jomwebplayer&view=settings" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
    <div style="float:left; width:52%">
      <fieldset class="adminform">
      <legend>Player Settings</legend>
      <table class="admintable">
        <tr>
          <td class="key" width="120">Width [px]</td>
          <td><input type="text" name="width"  value="<?php echo $settings->width; ?>"/></td>
        </tr>
        <tr>
          <td class="key">Height [px]</td>
          <td><input type="text" name="height"  value="<?php echo $settings->height; ?>"/></td>
        </tr>
        <tr>
          <td class="key">Show Video Title</td>
          <td><?php echo $this->title; ?></td>
        </tr>
        <tr>
          <td class="key">Show Video Description</td>
          <td><?php echo $this->description; ?></td>
        </tr>
        <tr>
          <td class="key">Skin Mode</td>
          <td><select name="skinmode">
              <option value="float" id="float" >Float</option>
              <option value="static" id="static" >Static</option>
            </select>
            <?php echo '<script>document.getElementById("'.$settings->skinmode.'").selected="selected"</script>'; ?> </td>
        </tr>
        <tr>
          <td class="key">Stretch Type</td>
          <td><select name="stretchtype">
              <option value="fill" id="fill" >Fill</option>
              <option value="uniform" id="uniform" >Uniform</option>
              <option value="none" id="none" >Original</option>
              <option value="exactfit" id="exactfit" >Exact Fit</option>
            </select>
            <?php echo '<script>document.getElementById("'.$settings->stretchtype.'").selected="selected"</script>'; ?> </td>
        </tr>
        <tr>
          <td class="key">Buffer Time [secs]</td>
          <td><input type="text" name="buffertime" value="<?php echo $settings->buffertime; ?>" /></td>
        </tr>
        <tr>
          <td class="key">Volume Level [%]</td>
          <td><input type="text" name="volumelevel" value="<?php echo $settings->volumelevel; ?>" /></td>
        </tr>
        <tr>
          <td class="key">Autoplay</td>
          <td><input type="checkbox" name="autoplay" value="1" <?php if($settings->autoplay==1){echo 'checked="checked" ';} ?> /></td>
        </tr>
        <tr>
          <td class="key">Playlist Autoplay</td>
          <td><input type="checkbox" name="playlistautoplay" value="1" <?php if($settings->playlistautoplay==1){echo 'checked="checked" ';} ?> /></td>
        </tr>
        <tr>
          <td class="key">Playlist Open by Default</td>
          <td><input type="checkbox" name="playlistopen" value="1" <?php if($settings->playlistopen==1){echo 'checked="checked" ';} ?> /></td>
        </tr>
        <tr>
          <td class="key">Random Playlist</td>
          <td><input type="checkbox" name="playlistrandom" value="1" <?php if($settings->playlistrandom==1){echo 'checked="checked" ';} ?> /></td>
        </tr>
      </table>
      </fieldset>
      <fieldset class="adminform">
      <legend>Skin Settings</legend>
      <table class="admintable">
        <tr>
          <td class="key" width="120">ControlBar</td>
          <td><input type="checkbox" name="controlbar" value="1" <?php if($skin->controlbar==1){echo 'checked="checked" ';} ?> /></td>
        </tr>
        <tr>
          <td class="key">PlayPause</td>
          <td><input type="checkbox" name="playpause" value="1" <?php if($skin->playpause==1){echo 'checked="checked" ';} ?> /></td>
        </tr>
        <tr>
          <td class="key">ProgressBar</td>
          <td><input type="checkbox" name="progressbar" value="1" <?php if($skin->progressbar==1){echo 'checked="checked" ';} ?> /></td>
        </tr>
        <tr>
          <td class="key">Timer</td>
          <td><input type="checkbox" name="timer" value="1" <?php if($skin->timer==1){echo 'checked="checked" ';} ?> /></td>
        </tr>
        <tr>
          <td class="key">Share</td>
          <td><input type="checkbox" name="share" value="1" <?php if($skin->share==1){echo 'checked="checked" ';} ?> /></td>
        </tr>
        <tr>
          <td class="key">Volume</td>
          <td><input type="checkbox" name="volume" value="1" <?php if($skin->volume==1){echo 'checked="checked" ';} ?> /></td>
        </tr>
        <tr>
          <td class="key">FullScreen</td>
          <td><input type="checkbox" name="fullscreen" value="1" <?php if($skin->fullscreen==1){echo 'checked="checked" ';} ?> /></td>
        </tr>
        <tr>
          <td class="key">PlayDock</td>
          <td><input type="checkbox" name="playdock" value="1" <?php if($skin->playdock==1){echo 'checked="checked" ';} ?> /></td>
        </tr>
        <tr>
          <td class="key">PlayList</td>
          <td><input type="checkbox" name="videogallery" value="1" <?php if($skin->videogallery==1){echo 'checked="checked" ';} ?> /></td>
        </tr>
      </table>
      </fieldset>
    </div>
    <div style="float:right;width:48%; color:#333333;">
      <fieldset class="adminform">
      <legend>Gallery Settings</legend>
      <table class="admintable">
        <tr>
          <td class="key" width="120">No. of Rows</td>
          <td><input type="text" name="rows" value="<?php echo $settings->rows; ?>" /></td>
        </tr>
        <tr>
          <td class="key">No. of Cols</td>
          <td><input type="text" name="cols" value="<?php echo $settings->cols; ?>" /></td>
        </tr>
        <tr>
          <td class="key">Thumbnail Width</td>
          <td><input type="text" name="thumbwidth" value="<?php echo $settings->thumbwidth; ?>" /></td>
        </tr>
        <tr>
          <td class="key">Thumbnail Height</td>
          <td><input type="text" name="thumbheight" value="<?php echo $settings->thumbheight; ?>" /></td>
        </tr>
        <tr>
          <td class="key">Show Sub Categories</td>
          <td><?php echo $this->subcategories; ?></td>
        </tr>
        <tr>
          <td class="key">Show Related Videos</td>
          <td><?php echo $this->relatedvideos; ?></td>
        </tr>
      </table>
      </fieldset>
      <fieldset class="adminform">
      <legend>Server Settings (Optional)</legend>
      <table class="admintable">
        <tr>
          <td class="key" width="120">FFMPEG</td>
          <td><input type="text" name="ffmpeg" value="<?php echo $settings->ffmpeg; ?>" /></td>
        </tr>
        <tr>
          <td class="key">Flvtool2</td>
          <td><input type="text" name="flvtool2" value="<?php echo $settings->flvtool2; ?>" /></td>
        </tr>
        <tr>
          <td class="key">QT Faststart</td>
          <td><input type="text" name="qtfaststart" value="<?php echo $settings->qtfaststart; ?>" /></td>
        </tr>
      </table>
      </fieldset>
      <fieldset class="adminform">
      <legend>License Settings (Optional)</legend>
      <table class="admintable">
        <tr>
          <td class="key" width="120">Licence Key</td>
          <td><input type="text" name="licensekey" size="60" value="<?php echo $settings->licensekey; ?>" /></td>
        </tr>
        <tr>
          <td class="key">Logo</td>
          <td><div id="var_logo">
              <?php if($settings->logo) { ?>
              <input name="logo" readonly="readonly" value="<?php echo $settings->logo; ?>"  size="47" />
              <input type="button" name="change" value="Change" onclick="uploadMode()" />
              <?php } else { ?>
              <input type="file" name="logo" accept="image/jpg/jpeg/png/gif" maxlength="100" />
              <?php } ?>
            </div></td>
        </tr>
        <tr>
          <td class="key">Logo Position</td>
          <td><select name="logoposition">
              <option value="topright" id="topright" >Top Right</option>
              <option value="topleft" id="topleft" >Top Left</option>
              <option value="bottomleft" id="bottomleft" >Bottom Left</option>
              <option value="bottomright" id="bottomright" >Bottom Right</option>
              <option value="center" id="center" >Center</option>
            </select>
            <?php echo '<script>document.getElementById("'.$settings->logoposition.'").selected="selected"</script>'; ?> </td>
        </tr>
        <tr>
          <td class="key">Logo Alpha [%]</td>
          <td><input type="text" name="logoalpha"  value="<?php echo $settings->logoalpha; ?>" /></td>
        </tr>
        <tr>
          <td class="key">Logo Target</td>
          <td><input type="text" name="logotarget" value="<?php echo $settings->logotarget; ?>" size="60" /></td>
        </tr>
      </table>
      </fieldset>
    </div>
    <div class="clr"></div>
    <input type="hidden" name="id" value="1" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="1" />
    <?php echo JHTML::_( 'form.token' ); ?>
  </form>
</div>
<script type="text/javascript">
if(<?php echo substr(JVERSION,0,3); ?> != '1.5') {
	Joomla.submitbutton = submitbutton;
}
 
function submitbutton(pressbutton) {
	var form            = document.adminForm;
	var imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'swf'];
	var isAllowed       = true;
	
 	if(pressbutton == 'save') {	
 		if (form.width.value == "") {
        	alert( "<?php echo JText::_( 'You must enter the Width for the Player', true); ?>" );
         	return;
     	}
		
		if (form.height.value == "") {
        	alert( "<?php echo JText::_( 'You must enter the Height for the Player', true); ?>" );
         	return;
     	}
		
		if(form.logo.value) {
			isAllowed = checkExtension('LOGO', form.logo.value, imageExtensions);
			if(isAllowed == false) 	return;
		} 		
	 }
	 submitform( pressbutton );
	 return;
}
 
function checkExtension(type, filePath, validExtensions) {
    if(filePath.indexOf('.') == -1) return false;
        
    var ext = filePath.substring(filePath.lastIndexOf('.') + 1).toLowerCase();
    
    for(var i = 0; i < validExtensions.length; i++) {
        if(ext == validExtensions[i]) return true;
    }

    alert(type + ' :   The file extension ' + ext.toUpperCase() + ' is not allowed!');
    return false;	
}

function uploadMode() {
    var mode;
    mode = '<input type="file" name="logo" style="border:none;" accept="image/jpg/jpeg/png/gif" maxlength="100" />';
    document.getElementById('var_logo').innerHTML = mode;
} 
</script>