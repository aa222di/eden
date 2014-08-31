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
// STUDENT SERVER
$eden['database']['dsn']            = 'mysql:host=blu-ray.student.bth.se;dbname=amab14;';
$eden['database']['username']       = 'amab14';
$eden['database']['password']       = 'pkDx9lF+';
$eden['database']['driver_options'] =  array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");

$eden['database']['mysql']   = '/usr/bin/mysql';         
$eden['database']['host']    = 'blu-ray.student.bth.se';

/*
// Local host
$eden['database']['dsn']            = 'mysql:host=localhost;dbname=projectRM;';
$eden['database']['username']       = 'root';
$eden['database']['password']       = 'root';
$eden['database']['driver_options'] =  array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");

$eden['database']['mysql']    = '/Applications/MAMP/Library/bin/mysql';
$eden['database']['host']     = 'localhost';
*/

$eden['database']['sql']     = 'RentalMovies.sql';


// jQuery, modernizr, and javascript


$eden['jQuery'] = "//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js";
$eden['jQuery'] = "js/jquery.js";
$eden['modernizr'] = "js/modernizr.js";
$eden['javascript_include'] = array();

 
/**
 * Site wide settings.
 *
 */
 
/**
 * Head
 *
 */ 
 
$eden['lang']             = 'en';
$eden['title_append']     = ' | Rental Movies';
$eden['stylesheets']      = array('css/grid.css', 'css/basic.css',);
$eden['favicon']          = 'img/RentalMoviesIcon.ico';


/**
 * Body
 *
 */
 
 
// HEADER

$eden['header'] = <<<EOD
<a href='home.php' class="left" title='Start page'><img src='img/IsoLogotype.png' alt="Rental Movies" class="logo"/></a>
EOD;

// SEARCH FIELD
$CSearch = new CSearch($eden['database']);
$eden['searchfield'] = $CSearch->form();
$CSearch->Search();

// ADMIN HEADER

$eden['headerAdmin'] = <<<EOD
<a href='home.php' title='Back to page'  class="admin-logo"><img src='img/IsoLogotype2.png' alt="Rental Movies"/>
Back to page  &gt;&gt;&gt;</a>
EOD;
 
//NAVBAR 
 
 $eden['navbar'] = array(
  'class' => 'mainmenu right',
  'items' => array(
    //'start'                     => array('text'=>'Start',           'url' =>'home.php',                   'title' => 'Home'),
    'movies'                    => array('text'=>'Movies',          'url' =>'moviecatalogue.php',         'title' => 'Our movie catalogue'),
    'news'                      => array('text'=>'News',            'url' =>'newsblog.php',               'title' => 'Read about our latest news!'),
    'about us'    	            => array('text'=>'About us',        'url' =>'about.php',    	            'title' => 'About Rental Movies'),
    'competition'    	          => array('text'=>'Competition',     'url' =>'competition.php',   	        'title' => 'Win a movie in our monthly competition!',)
  ),
  'callback' => function($url) {
    if(basename($_SERVER['SCRIPT_FILENAME']) == $url) {
      return true;
    }
  }
);

 // TOPNAV

  if(!isset($_SESSION['user'])){
  $eden['topnav'] = array(
  'class' => 'topnav right',
  'items' => array(
    'login'                     => array('text'=>'login',           'url' =>'login.php',                   'title' => 'login'),
  ),
  'callback' => function($url) {
    if(basename($_SERVER['SCRIPT_FILENAME']) == $url) {
      return true;
    }
  }
);
}

  else if(isset($_SESSION['user'])){
  $eden['topnav'] = array(
  'class' => 'topnav right',
  'items' => array(
    'user'             => array('text'=> $_SESSION['user']->name,             'url' =>'profile.php',                   'title' => 'Go to profile',
        'submenu'         => array(
            'items'           => array('logout' => array('text'=> 'Log out',  'url' =>'login.php?logout', 'title' => 'logout',),
                              ),
            ),
    
  ),),
  'callback' => function($url) {
    if(basename($_SERVER['SCRIPT_FILENAME']) == $url) {
      return true;
    }
  }
);
}

// ADMIN NAV

$eden['adminnav'] = array(
  'class' => 'admin-nav',
  'items' => array(
    'user'             => array('text'=> 'User',             'url' =>'profile.php',                       'title' => 'Go to profile',
        'submenu'         => array(
            'items'           => array( 'view'  => array(   'text'=> 'View profile',  'url' =>'profile.php',                         'title' => 'Go to profile',),
                                        'edit'  => array(   'text'=> 'Edit profile',  'url' =>'edit.php?table=users&amp;id=current',   'title' => 'Edit profile',),
                                        'users' => array(   'text'=> 'View all users','url' =>'viewusers.php',                       'title' => 'View all users',),
                                        'create'=> array(   'text'=> 'Add new user',  'url' =>'createuser.php',                      'title' => 'Add new user',),
                                        'logout'=> array(   'text'=> 'Log out',       'url' =>'login.php?logout',                    'title' => 'Logout',),
                              ),
            ),
    
  ),
    'blog'             => array('text'=> 'Blog',             'url' =>'viewposts.php',                     'title' => 'View all posts',
        'submenu'         => array(
            'items'           => array( 'view' => array(   'text'=> 'View all posts',  'url' =>'viewposts.php',      'title' => 'View all posts',),
                                        'create' => array( 'text'=> 'Create new post', 'url' =>'createpost.php',     'title' => 'Create new post',),
                                        'page'   => array('text'=> 'Page - About Us',  'url' =>'edit.php?table=page&amp;id=about-us',       'title' => 'Edit about us page',),
                              ),
            ),
    
  ),
    'movies'             => array('text'=> 'Movies',          'url' =>'viewmovies.php',                   'title' => 'View all movies',
        'submenu'         => array(
            'items'           => array( 'view' => array(   'text'=> 'View all movies', 'url' =>'viewmovies.php',      'title' => 'View all movies',),
                                        'create' => array( 'text'=> 'Add new movie',   'url' =>'createmovie.php',     'title' => 'Create new movie',),
                              ),
            ),
    
  ),
     'restore'             => array('text'=> 'Restore the database',          'url' =>'restore.php',                   'title' => 'Restore the database',),
 ),
  'callback' => function($url) {
    if(basename($_SERVER['SCRIPT_FILENAME']) == $url) {
      return true;
    }
  }
);
 
 
// FOOTER

$eden['footer'] = <<<EOD
<span class='sitefooter'><h5 class='center'>Copyright (c) Rental Movies | <a href='http://validator.w3.org/unicorn/check?ucn_uri=referer&amp;ucn_task=conformance'>Unicorn</a></h5></span>
EOD;

