<?php 
/**
 * This is a Eden pagecontroller.
 *
 */
// Include the essential config-file which also creates the $anax variable with its defaults.
include(__DIR__.'/config.php'); 
$db = new CDatabase($eden['database']); 



$sql = "SELECT * FROM Movie";
$res = $db->ExecuteSelectQueryAndFetchAll($sql);



$table = "<table><thead><th>ID</th><th>Titel</th><th>År</th><th>Bild</th><th>Ta bort</th></thead><tbody>";

foreach($res as $key=>$val) {
	$table .= "<tr><td>{$val->id}</td><td>{$val->title}</td><td>{$val->year}</td><td>{$val->image}</td><td><a href='movie_delete.php?id={$val->id}'>X</a></td></tr>";


}
$table .= "</tbody></table>";

// Do it and store it all in variables in the Eden container.
$eden['title'] = "Ta bort filmer";
 

 
$eden['main'] = <<<EOD
<h2>Uppdatera filmer</h2>

$table

EOD;
 

 
 
// Finally, leave it all to the rendering phase of Eden.
include(EDEN_THEME_PATH);
