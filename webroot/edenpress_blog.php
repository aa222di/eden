<?php 
/**
 * This is a Eden pagecontroller.
 *
 */
// Include the essential config-file which also creates the $anax variable with its defaults.
include(__DIR__.'/config.php'); 
 
$blog = new CBlog($eden['database']['edenpress']);





// Get parameters
$slug = isset($_GET['slug']) ? $_GET['slug'] : null;
// Get content
$html = $blog->getPosts($slug);
$debug = $blog->Dump();

// Store variables in the eden object
$eden['title'] = 'Bloggen';
$eden['main'] = $html . '<hr>' . $debug;


 
 
// Finally, leave it all to the rendering phase of Eden.
include(EDEN_THEME_PATH);
