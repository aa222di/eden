<?php 
/**
 * This is a Eden pagecontroller.
 *
 */
// Include the essential config-file which also creates the $anax variable with its defaults.
include(__DIR__.'/config.php'); 
 
$content = new CContent($eden['database']['edenpress'], 'Content');



if (isset($_GET['delete'])) {
	$output = $content->deleteContent($_GET['id']);
}
else {
	$output = null;
}

$html = $content->ShowAllContent();
$debug = $content->Dump();
// Do it and store it all in variables in the Eden container.
$eden['title'] = "Edenpress";
 
$eden['main'] = $output . $html . $debug;
 
// Finally, leave it all to the rendering phase of Eden.
include(EDEN_THEME_PATH);
