<?php

/*
 * @version		$Id: default.php 3.1.0 2012-10-28 $
 * @package		Joomla
 * @subpackage	jomwebplayer
 * @copyright   Copyright (C) 2012-2014 Jom Webplayer
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');
$data = $this->data[0];
?>

<div id="jomwebplayer">
  <form action="index.php?option=com_jomwebplayer&view=googleads" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
    <fieldset class="adminform">
    <legend>Google Adds</legend>
    <table class="admintable">
      <tr>
        <td class="key">Ad Size</td>
        <td><select>
            <option>300 x 250</option>
          </select>
        </td>
      </tr>
      <tr>
        <td class="key" valign="top" style="padding-top:10px !important;">Your Adsense Code</td>
        <td colspan="3"><textarea rows="10" cols="60" name="adscript" ><?php echo $data->adscript; ?></textarea></td>
      </tr>
      <tr>
        <td class="key">Component</td>
        <td><input type="checkbox" name="component" value="1" <?php if($data->component == '1') echo 'checked'; ?> /></td>
      </tr>
      <tr>
        <td class="key">Module</td>
        <td><input type="checkbox" name="module" value="1" <?php if($data->module == '1') echo 'checked'; ?> /></td>
      </tr>
      <tr>
        <td class="key">Plugin</td>
        <td><input type="checkbox" name="plugin" value="1" <?php if($data->plugin == '1') echo 'checked'; ?> /></td>
      </tr>
    </table>
    </fieldset>
    <input type="hidden" name="id" value="<?php echo $data->id; ?>" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="1" />
    <?php echo JHTML::_( 'form.token' ); ?>
  </form>
</div>
<script type="text/javascript">
if(<?php echo substr(JVERSION,0,3); ?> != '1.5') {
	Joomla.submitbutton = submitbutton;
}
 
function submitbutton(pressbutton){
	var form = document.adminForm;
 	if(pressbutton == 'save') {
 		if (form.adscript.value == "") {
        	alert( "<?php echo JText::_( 'You must enter the Google Adsense Script', true); ?>" );
         	return;
     	}
	 }
	 
	 submitform( pressbutton );
	 return;
}
</script>