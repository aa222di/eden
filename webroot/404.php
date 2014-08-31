<?php 
/**
 * This is a Eden pagecontroller.
 *
 */
// Include the essential config-file which also creates the $anax variable with its defaults.
include(__DIR__.'/config.php'); 
 
 
// Do it and store it all in variables in the Anax container.
$eden['title'] = "404";
 

 
$eden['main'] = <<<EOD
<div class="grid">
	<h1>Oups!</h1>
	<p>We can't seem to find what you are looking for.</p>
</div>
EOD;
 

 
 
// Finally, leave it all to the rendering phase of Eden.
include(EDEN_THEME_PATH);
