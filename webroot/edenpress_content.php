<?php 
/**
 * This is a Eden pagecontroller.
 *
 */
// Include the essential config-file which also creates the $anax variable with its defaults.
include(__DIR__.'/config.php'); 
 
$content = new CContent($eden['database']['edenpress']);

// Restore the database to its original settings
$reset = '<a class="smallbutton" href="?reset">Återskapa databasen</a>';
$sql      = 'content.sql';             
//$mysql    = '/usr/bin/mysql';         
//$host     = 'blu-ray.student.bth.se';
$mysql    = '/Applications/MAMP/Library/bin/mysql';
$host     = 'localhost';

if (isset($_GET['reset'])) {
	$output = $content->ResetDatabase($sql, $mysql, $host);
}

elseif (isset($_GET['create'])) {
	$output = $content->createTable();
}

elseif (isset($_GET['delete'])) {
	$output = $content->deleteContent($_GET['id']);
}
else {
	$output = null;
}

$html = $content->ShowAllContent();
$debug = '<hr>' . $content->Dump();
//$session = print_r($_SESSION['user']);
// Do it and store it all in variables in the Eden container.
$eden['title'] = "Edenpress";
 
$eden['main'] =  $output . $html . $reset . $debug;
 
// Finally, leave it all to the rendering phase of Eden.
include(EDEN_THEME_PATH);
