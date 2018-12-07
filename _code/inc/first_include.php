<?php
/******** TO DO ********
 * admin: add option to move items: 
 * sub-sections to any other section, or out of section up to top level
 * files to any other section or sub-section
 * admin preferences: add font-size option (or in edit_text?)
 * edit_text: add font colors, allow more html, float images...
 * 
 */
session_start();

// set version, to load fresh css and js
$version = 33;

// initialize site 
define("SITE", $_SERVER['HTTP_HOST'].'/');
// Protocol: http vs https
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
define("PROTOCOL", $protocol);
// document root (beware of inconsistent trailing slash depending on environment, hence the use of realpth)
define("ROOT", realpath($_SERVER['DOCUMENT_ROOT']).'/');
// reference to site author...
define("AUTHOR_REF", 'sebdedie@gmail.com');
// content directory (which contains all user files)
define("CONTENT", '_content/');

// php root and error reporting, local vs. remote
if( strstr(SITE,'.local') ){ 					// local server
	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);
	define( 'DISPLAY_DEBUG', TRUE );
	define( 'LOG_ERRORS', TRUE );
}else{ 											// remote server
	ini_set('display_errors', 0);
	define("SEND_ERRORS_TO", AUTHOR_REF);
	define( 'DISPLAY_DEBUG', FALSE );
	define( 'LOG_ERRORS', TRUE );
}

// error handler
require(ROOT.'_code/errors.php');


// create _content dir if it does not exist
/*if( !file_exists(ROOT.'_content') ){
	mkdir(ROOT.'_content', 0766);
}*/
// create error reporting file  if it does not exist
if( !file_exists(ROOT.CONTENT.'hGtDjkpPWSXk.php') ){
	if( !$fp = fopen(ROOT.CONTENT.'hGtDjkpPWSXk.php', 'w') ){
		echo '<p style="color:red;">Error: Could not create error log!</p>';
	}
}


// menu file (used as site structure)
define("MENU_FILE", ROOT.CONTENT.'menu.txt');
// create menu file if it does not exist
if(!file_exists(MENU_FILE)){
	if( !$fp = fopen(MENU_FILE, 'w') ){
		echo '<p style="color:red;">Error: Could not create menu file!</p>';
	}
}

// reference paths
define("CONTEXT_PATH", str_replace( ROOT, '', getcwd() ) );
define("SECTION", basename(CONTEXT_PATH) );

// reserved names
define("SYSTEM_NAMES", '/^_?(lang-2|admin)$/');

// default languages (more can be added by user, array will be extended in user_custom.php)
$languages = array();
$languages['english'] = array('seo'=>'en', 'more'=>'more', 'back'=>'back');
$languages['français'] = array('seo'=>'fr', 'more'=>'plus', 'back'=>'retour');
$languages['deutsch'] = array('seo'=>'de', 'more'=>'mehr', 'back'=>'zurück');
$languages['español'] = array('seo'=>'es', 'more'=>'más', 'back'=>'volver');

// require custom parameters set by user (first_lang and second_lang, css style, username, admin creds...)
require(ROOT.CONTENT.'user_custom.php');

// nav layout
define("CSS", $css);

// $sub_section_scroll, set in requiered file above, is used within functions...
define("SHOW_SUB_NAV", $show_sub_nav);

// $sub_section_scroll, set in requiered file above, is used within functions...
define("SUB_SECTION_SCROLL", $sub_section_scroll);

// set allowed tags for strip_tags function, used for validating user txt input
define("ALLOWED_TAGS", '<b><strong><br><u><i><a><h1><h2><h3><span><div><img>');

// language dependent constants (for 'more' and 'back' links)
define("FIRST_LANG", $first_lang);
define("SECOND_LANG", $second_lang);
// language directory that will let the site know it should switch to second language.
// if this value is changed, it must also be changed in .htaccess!  
define("LANG_DIR", 'lang-2/');

// language (en/de) - set by GET query, stored as cookie
/*if(isset($_GET['lang']) && ($_GET['lang'] == 'en' || $_GET['lang'] == 'de')){
    if(isset($_COOKIE['lang'])){
        setcookie ("lang", "", time() - 3600); // delete cookie!
    }
    $_COOKIE['lang'] = $_GET['lang']; // set global var
    setcookie("lang", $_GET['lang'], time()+60*60*24*30, '/'); // set cookie
}
if(isset($_COOKIE['lang']) && ($_COOKIE['lang'] == 'en' || $_COOKIE['lang'] == 'de') ){
    $lang = $_COOKIE['lang'];
}else{
    $lang = "en"; // default
}*/
if( strstr($_SERVER['REQUEST_URI'], '/'.LANG_DIR) || ( isset($_GET['lang']) && $_GET['lang']=='de') ){
	$lang = 'de';
	define("LANG_LINK", LANG_DIR);
}else{ // default
	$lang = "en"; 
	define("LANG_LINK", '');
}
define("LANG", $lang);

if(LANG == 'en'){ // en means $first_lang (not "english")
	$user = $user_en;
	if( !array_key_exists($first_lang, $languages) ){ // if first lang is not part of the lang array
		$default_lang = 'english';
	}else{
		$default_lang = $first_lang;
	}
	if( !array_key_exists($second_lang, $languages) ){ // if second lang is not part of the lang array
		$other_lang = 'deutsch';
	}else{
		$other_lang = $second_lang;
	}
	
}elseif(LANG == 'de'){ // de means $second_lang (not "Deustch")
	$user = $user_de;
	if( !array_key_exists($second_lang, $languages) ){ // if first lang is not part of the lang array
		$default_lang = 'Deustch';
	}else{
		$default_lang = $second_lang;
	}
	if( !array_key_exists($first_lang, $languages) ){ // if second lang is not part of the lang array
		$other_lang = 'english';
	}else{
		$other_lang = $first_lang;
	}
}

define("USER", $user);
define("MORE", $languages[$default_lang]['more']);
define("BACK", $languages[$default_lang]['back']);
define("SEO_LANG", $languages[$default_lang]['seo']);
define("OTHER_LANG", $languages[$other_lang]['seo']);

// FILE TYPES
$types = array();
// ALL
$types['supported_types'] = '/^\.(jpe?g?|png|gif|s?html?|txt|mp3|m4a|oga?g?|wav|mp4|m4v|webm|ogv|pdf|docx?|msword|odt)$/i';
// TEXT
$types['text_types'] = '/^\.(s?html?|txt)$/i';
// audio
$types['audio_types'] = '/^\.(mp3|m4a|oga?g?|wav)$/i';
// video
$types['video_types'] = '/^\.(mp4|m4v|webm|ogv)$/i';
// resizable
$types['resizable_types'] = '/^\.(jpe?g?|png|gif)$/i';
// only available for download
$types['download'] = '/^\.(pdf|docx?|msword|odt)$/i';
// register $types as a $_POST var, so it is accessible within functions scope (like a constant).
$_POST['types'] = $types;

// FILE SIZES:
$sizes = array();
$sizes['L'] = array("width"=>1500, "height"=>1100);
$sizes['M'] = array("width"=>800, "height"=>650);
$sizes['S'] = array("width"=>300, "height"=>250);
// register $sizes as a $_POST var, so it is accessible within functions scope.
$_POST['sizes'] = $sizes;

// image size 
$size = "_M";
if(isset($_COOKIE['wW'])){
    if($_COOKIE['wW'] > 980 ){
        $size = "_L";
    }elseif($_COOKIE['wW'] < 340){
		$size = "_S";
	}
}
define("SIZE", $size);

// require common functions
require(ROOT.'_code/inc/functions.php');

// max upload size (after including functions, for 
$max_upload_size = ini_get('upload_max_filesize');
$max_upload_bytes = return_bytes($max_upload_size);
define("MAX_UPLOAD_SIZE", $max_upload_size);
define("MAX_UPLOAD_BYTES", $max_upload_bytes);

