<?php 
/**
 * This is a Eden pagecontroller.
 *
 */
// Include the essential config-file which also creates the $anax variable with its defaults.
include(__DIR__.'/config.php'); 
 
 
// Do it and store it all in variables in the Anax container.
$eden['title'] = "Hello World";
 

 
$eden['main'] = <<<EOD
<h2>Hej Världen</h2>
<p>Detta är en exempelsida som visar hur Eden ser ut och fungerar.</p>
EOD;
 

 
 
// Finally, leave it all to the rendering phase of Eden.
include(EDEN_THEME_PATH);
