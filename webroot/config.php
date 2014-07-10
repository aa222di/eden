<?php
/**
 * Config-file for Eden. Change settings here to affect installation.
 *
 */
 
/**
 * Set the error reporting.
 *
 */
error_reporting(-1);              // Report all type of errors
ini_set('display_errors', 1);     // Display all errors 
ini_set('output_buffering', 0);   // Do not buffer outputs, write directly
 
 
/**
 * Define Eden paths.
 *
 */
define('EDEN_INSTALL_PATH', __DIR__ . '/..');
define('EDEN_THEME_PATH', EDEN_INSTALL_PATH . '/theme/render.php');
 
 
/**
 * Include bootstrapping functions.
 *
 */
include(EDEN_INSTALL_PATH . '/src/bootstrap.php');
 
 
/**
 * Start the session.
 *
 */
session_name(preg_replace('/[^a-z\d]/i', '', __DIR__));
session_start();
 
 
/**
 * Create the Eden variable.
 *
 */
$eden = array();
 

/**
 * Settings for the database.
 *
 */
 
$eden['database']['dsn'] 		       	= 'mysql:host=localhost;dbname=Movie;';
$eden['database']['username'] 		  = 'root';
$eden['database']['password']	  	  = 'root';
$eden['database']['driver_options']	=  array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");

 
/**
 * Site wide settings.
 *
 */
 
/**
 * Head
 *
 */ 
 
$eden['lang']             = 'sv';
$eden['title_append']     = ' | Eden en webbtemplate';
$eden['stylesheets']      = array('css/grid.css', 'css/basic.css');
$eden['favicon']          = 'img/edenlogo.ico';


/**
 * Body
 *
 */
 
 
// HEADER

$eden['header'] = <<<EOD
<h1>eden.</h1>


EOD;
 
//NAVBAR 
 
 $eden['navbar'] = array(
  'class' => 'mainmenu',
  'items' => array(
    'hem'                 => array('text'=>'Hem',                  'url'         =>'me.php',                'title' => 'Min presentation om mig själv'),
    'redovisning'         => array('text'=>'Redovisning',          'url'         =>'redovisning.php',       'title' => 'Redovisningar för kursmomenten'),
    'kallkod'             => array('text'=>'Källkod',              'url'         =>'source.php',            'title' => 'Se källkoden'),
    'dice'    	          => array('text'=>'Tärningsspel',         'url'         =>'dice.php',    	        'title' => 'Spela tärningsspelet'),
    'movie'    	          => array('text'=>'MovieDB',              'url'         =>'movie.php',   	        'title' => 'Filmdatabasen'),
    'movie_showall'    	  => array('text'=>'Visa alla filmer',     'url'         =>'movie_showall.php',   	'title' => 'Visa alla filmer'),
    'login'    	          => array('text'=>'Logga in',             'url'         =>'login.php',   	        'title' => 'Logga in'),
    'movie_update'        => array('text'=>'Uppdatera',            'url'         =>'movie_updateview.php',	'title' => 'Uppdatera filmdatabasen'),
    'movie_create'        => array('text'=>'Lägg till film',       'url'         =>'movie_create.php',	    'title' => 'Lägg till filmer'),
    'movie_delete'        => array('text'=>'Ta bort film',         'url'         =>'movie_deleteview.php',	'title' => 'Ta bort filmer'),
    'movie_searchtitle'   => array('text'=>'Sök titel',            'url'         =>'movie_searchtitle.php',	'title' => 'Sök titel'),
    'movie_year'          => array('text'=>'Sök på år',            'url'         =>'movie_year.php',	      'title' => 'Sök på år'),
  ),
  'callback_selected' => function($url) {
    if(basename($_SERVER['SCRIPT_FILENAME']) == $url) {
      return true;
    }
  }
);

// FOOTER

$eden['footer'] = <<<EOD
<span class='sitefooter'>Copyright (c) Amanda Marie Åberg | <a href='http://validator.w3.org/unicorn/check?ucn_uri=referer&amp;ucn_task=conformance'>Unicorn</a></span>
EOD;

