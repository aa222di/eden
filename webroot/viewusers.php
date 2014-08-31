<?php 
/**
 * This is a Eden pagecontroller.
 *
 */
// Include the essential config-file which also creates the $anax variable with its defaults.
include(__DIR__.'/config.php'); 
 $eden['stylesheets'][] = 'css/admin.css'; 
 
 $CAdmin = new CAdmin($eden['database']);
 $table = $CAdmin->view('users');

 
// Do it and store it all in variables in the Anax container.
$eden['title'] = "View all users";
 

 
$eden['main'] = <<<EOD
<div class='grid'>
<h1>View all users</h1>
$table
</div>
EOD;
 

 
 
// Finally, leave it all to the rendering phase of Eden.
include(EDEN_THEME_PATH);
