<?php 
/**
 * This is a Eden pagecontroller.
 *
 */
// Include the essential config-file which also creates the $anax variable with its defaults.
include(__DIR__.'/config.php'); 
 

// Add style for csource
$eden['stylesheets'][] = 'css/source.css';
 
// Create the object to display sourcecode
//$source = new CSource();
$source = new CSource(array('secure_dir' => '..', 'base_dir' => '..'));



// Do it and store it all in variables in the Anax container.
$eden['title'] = "Visa källkod";
 

 
$eden['main'] = "<h2>Visa källkod</h2>\n" . $source->View();
 

 
 
// Finally, leave it all to the rendering phase of Eden.
include(EDEN_THEME_PATH);
