/*
 * @version		$Id: jomwebplayer.js 3.1.0 2012-10-28 $
 * @package		Joomla
 * @copyright   Copyright (C) 2012-2014 Jom Webplayer
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

function jomwebplayerflashcallback(title, description, uid) {	
	if(!uid) { uid = ''; }
	if(!description) { description = ''; }
	var title_id = "jomwebplayer_title" + uid;
	var desc_id  = "jomwebplayer_description" + uid;
	
	effectFadeIn(title_id, title);
	effectFadeIn(desc_id, description);
}

function effectFadeIn(idname, val) {
	try {
	  $("#"+idname).fadeOut(500);
      setTimeout( function() { effectFadeOut(idname,val); }, 500 );
	} catch(err) { }
}
	
function effectFadeOut(idname, val) {
	try {
      document.getElementById(idname).innerHTML = val;
      $("#"+idname).fadeIn(500);
	} catch(err) { }
}

function hideAd(cont, over) {
 document.getElementById(cont).style.display = 'none';
 document.getElementById(over).style.display = 'none';
}