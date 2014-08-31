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

if (isset($_GET['output'])) {
	if ($_GET['output'] == 'success') {
		$output = "<output class='success'>Your changes have been succesfully saved</output>";
	}
	else {
		$output = "<output class='failure'>Something went wrong and you changes havn't been saved</output>";
	}
}

if (isset($_POST['submit'])) {
	$CAdmin->updateContent($table, $id);
}

$form = $CAdmin->getForm($table, $id);
$content = $CAdmin->getObject($table, $id);
$title = isset($content->title) ? $content->title : 'profile';

// Do it and store it all in variables in the Anax container.
$eden['title'] = "Edit";
 
$eden['main'] = <<<EOD
<div class='grid'>
<h1>Edit {$title}</h1>
$output
$form
</div>
EOD;
 

 
 
// Finally, leave it all to the rendering phase of Eden.
include(EDEN_THEME_PATH);
