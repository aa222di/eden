<?php 
/**
 * This is a Eden pagecontroller.
 *
 */
// Include the essential config-file which also creates the $anax variable with its defaults.
include(__DIR__.'/config.php'); 
$eden['stylesheets'][] = 'css/admin.css'; 
$CAdmin = new CAdmin($eden['database']);

$table = 'movies';
$id = null;

$form = $CAdmin->getForm($table, $id);
$movie = $CAdmin->getObject($table, $id);

if (isset($_POST['submit'])) {
	$CAdmin->createContent($table, $id);
}

if (isset($_GET['output'])) {
	if ($_GET['output'] == 'success') {
		$output = "<output class='success'>Your changes have been succesfully saved</output>";
	}
	else {
		$output = "<output class='failure'>Something went wrong and you changes havn't been saved</output>";
	}

}

// Do it and store it all in variables in the Anax container.
$eden['title'] = "Add new movie";
 

 
$eden['main'] = <<<EOD
<div class='grid'>
<h1>Add new movie</h1>
$form
</div>
EOD;

 
 
// Finally, leave it all to the rendering phase of Eden.
include(EDEN_THEME_PATH);
