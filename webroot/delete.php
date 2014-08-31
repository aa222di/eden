<?php 
/**
 * This is a Eden pagecontroller.
 *
 */
// Include the essential config-file which also creates the $anax variable with its defaults.
include(__DIR__.'/config.php'); 
$eden['stylesheets'][] = 'css/admin.css'; 

$CAdmin = new CAdmin($eden['database']);
$output = null;


$table = isset($_GET['table']) ? $_GET['table'] : null;
$id = isset($_GET['id']) ? $_GET['id'] : null;
$content = $CAdmin->getObject($table, $id);

$output = $CAdmin->deleteForm($table, $id);

if (isset($_POST['submit'])) {
	$output = $CAdmin->deleteContent($table, $id);

}


// Do it and store it all in variables in the Anax container.
$eden['title'] = "Delete";
  
$eden['main'] = <<<EOD
<div class='delete-page'>
$output
</div>
EOD;
 

 
 
// Finally, leave it all to the rendering phase of Eden.
include(EDEN_THEME_PATH);
