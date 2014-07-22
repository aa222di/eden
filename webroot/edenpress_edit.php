<?php 
/**
 * This is a Eden pagecontroller.
 *
 */
// Include the essential config-file which also creates the $anax variable with its defaults.
include(__DIR__.'/config.php'); 
 
// Connect to databases
$content = new CContent($eden['database']['edenpress'], 'Content');

$id = isset($_GET['id']) ? $_GET['id'] : null;
$html = $content->updateContent($id);
$debug = $content->Dump();


$eden['title'] = "Uppdatera innehåll";
$eden['main'] = $html . $debug;
 
 
// Finally, leave it all to the rendering phase of Eden.
include(EDEN_THEME_PATH);
